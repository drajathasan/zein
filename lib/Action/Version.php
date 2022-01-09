<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-21 13:42:04
 * @modify date 2021-12-21 13:42:04
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Action;

use ZipArchive;
use Zein\Http;

class Version extends Config
{
    private static $Instance = null;
    private $hasDownload = false;

    private function __construct()
    {
        if (!isset($_SESSION['versionCheck'])) $_SESSION['versionCheck'] = [];
    }

    private function checkupdate()
    {
        if (isset($_SESSION['versionCheck']['nextCheck']) && strtotime(date('Y-m-d H:i:s')) < $_SESSION['versionCheck']['nextCheck'])
        {
            Http::responseJson($_SESSION['versionCheck']['result']);
        }

        $Http = Http::getInstance();

        $Client = $Http->client();

        if (is_null($Client))
        {
            Http::responseJson(['status' => false, 'message' => $Http->getError()]);
        }

        $Release = $Client->pull('https://api.github.com/repos/drajathasan/zein/releases/latest');
        $Content = json_decode($Client->getContents(), true);
        $Result = [
            'status' => true,
            'data' => [
                'lastVersion' => $Content['tag_name'],
                'lastUpdateDate' => date('Y-m-d H:i:s', strtotime($Content['published_at'])),
                'downloadUrl' => $Content['zipball_url']
                ]
            ];
        
        $_SESSION['versionCheck'] = [
            'nextCheck' => date('Y-m-d H:i:s', strtotime('+5 minute')),
            'result' => $Result
        ];

        $Client->close();

        Http::responseJson($Result);
    }

    private function downloadlatest()
    {
        $versionCheck = $_SESSION['versionCheck']??[];
        if (!isset($versionCheck['nextCheck'])) Http::responseJson(['status' => false, 'message' => 'Please check update first!']);
        
        $Http = Http::getInstance();

        $Client = $Http->client();

        if (is_null($Client))
        {
            Http::responseJson(['status' => false, 'message' => $Http->getError()]);
        }

        $File = SB . 'files/cache/latest-zein.zip';
        $Client->download($versionCheck['result']['data']['downloadUrl'], $File);

        if (filesize($File) > 0)
        {
            self::$Instance->hasDownload = true;
            return $this->install($File);
        }

        Http::responseJson(['status' => false, 'message' => 'Failed download! : ' . $Client->getResult('error')]);
    }

    private function install(string $Filepath)
    {
        if (!self::$Instance->hasDownload) Http::responseJson(['status' => false, 'message' => 'Please download first.']);

        $Zip = new ZipArchive;
        $Dest = SB . 'admin/admin_template/';

        if ($Zip->open($Filepath) === TRUE)
        {
            $Zip->extractTo(SB . 'admin/admin_template/');
            $Zip->close();
        }

        $NewTemplate = array_values(array_filter(scandir(SB . 'admin/admin_template/'), function($folder){
            if (preg_match('/drajathasan-zein/', $folder))
            {
                return true;
            }
        }))[0]??'?';

        if ($NewTemplate === '?') Http::responseJson(['status' => false, 'message' => 'Something error! at installation']);

        // remove lastest folder
        rrmdir($Dest . 'zein-' . $_SESSION['versionCheck']['result']['data']['lastVersion']);

        // Renaming
        rename($Dest . $NewTemplate, $Dest . 'zein-' . $_SESSION['versionCheck']['result']['data']['lastVersion']);

        // remove extracting folder
        rrmdir($Dest . $NewTemplate);

        // set new template data
        $TemplateData = unserialize($this->getUserTemplate());

        $TemplateData['theme'] = 'zein-' . $_SESSION['versionCheck']['result']['data']['lastVersion'];

        // update database
        $this->updateTemplate(serialize($TemplateData));

        // Archiving old data if latest version is not good enough
        $this->archivingOldVersion();

        // Success
        Http::responseJson(['status' => true, 'message' => 'Update succussfull.']);
    }

    private function archivingOldVersion()
    {
        rename($this->Conf['admin_template']['theme'], 'zein-' . ZEIN_VERSION);
        // rrmdir($this->Conf['admin_template']['theme']);
    }

    public static function execute(array $Conf, array $Path)
    {
        if (is_null(self::$Instance))
        {
            self::$Instance = new Version($Conf);
        }

        try {
            $Method = $Path[1];
            self::$Instance->Path = $Path;
            self::$Instance->$Method();
        } catch (\Exception $e) {
            \utility::jsToastr($e->getMessage(), 'Error', 'danger');
        }
        exit;
    }
}