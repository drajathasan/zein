<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-07 13:23:43
 * @modify date 2021-12-07 13:23:43
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Action;
use Zein\Http;
use Zein\Ui\Html\{Element,Skeleton};
use SLiMS\DB;

class Config
{
    private static $Instance = null;
    protected $Conf;
    private $Path;

    private function __construct(array $Conf)
    {
        $this->Conf = $Conf;
    }

    private function save()
    {
        $this->Conf['admin_template']['config'] = [
            'color' => $_POST['color']??'#000'
        ];
        
        // create database instance;
        $DB = DB::getInstance();

        $State = $DB->prepare('update `user` set `admin_template` = ? where user_id = ?');
        $Update = $State->execute([serialize($this->Conf['admin_template']), $_SESSION['uid']??0]);

        // Remove cache
        self::removecache();

        echo Element::create('script', [], 'setTimeout(() => {parent.window.location = "' . AWB . '"}, 5000)');
        \utility::jsToastr('Data has been saved', 'Success', 'success');
    }

    private function resetcolor()
    {
        $DefaultColor = 'a:2:{s:5:"theme";s:4:"zein";s:3:"css";s:29:"admin_template/zein/style.css";}';

        DB::getInstance()
            ->prepare('update `user` set `admin_template` = ? where user_id = ?')
            ->execute([$DefaultColor, $_SESSION['uid']??0]);

        Skeleton::removeCache();

        Http::responseJson(['status' => true, 'message' => 'Data has been reseted']);
    }

    public static function removecache()
    {
        // Remove cache
        Skeleton::removeCache();

        if (Http::getMethod() === 'GET') Http::responseJson(['status' => true, 'message' => 'Data has been reseted']);
    }

    protected function getUserTemplate()
    {
        $DB = DB::getInstance();
        $UserTemplate = $DB->prepare('select `admin_template` from `user` where user_id = ?');
        $UserTemplate->execute([$_SESSION['uid']??0]);

        return ($UserTemplate->rowCount() === 0) ? '?' : $UserTemplate->fetch(\PDO::FETCH_NUM)[0];
    }

    protected function updateTemplate(string $NewTemplate)
    {
        DB::getInstance()
            ->prepare('update `user` set `admin_template` = ? where user_id = ?')
            ->execute([$NewTemplate, $_SESSION['uid']??0]);
    }

    public static function execute(array $Conf, array $Path)
    {
        if (is_null(self::$Instance))
        {
            self::$Instance = new Config($Conf);
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