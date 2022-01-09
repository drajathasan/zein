<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-21 07:57:28
 * @modify date 2021-12-21 07:57:28
 * @license GPLv3
 * @desc [description]
 */

namespace Zein;

use ZipArchive;
use utility;
use Zein\Ui\Components\Bs\Alert;

class Core
{
    private static $Instance = null;
    private $Error = [];

    private function __construct()
    {
    }

    private function issetCheck(): bool
    {
        return isset($this->Check);
    }

    private function throwError(string $ErrorMessage, string $Key)
    {
        $this->Error[$Key] = $ErrorMessage;
    }

    public function check()
    {
        $this->Check = [];
        return $this;
    }

    public function slimsVersion(): Core
    {
        // Failed chaining
        if (!$this->issetCheck()) $this->throwError('Failed chaining!', 'chainingFailed');

        // Version check
        if (SENAYAN_VERSION_TAG < '9.4.0') $this->throwError('Your SLiMS version is too old. Please upgrade to latest', 'slimsVersion');

        return $this;
    }

    public function zipCheck()
    {
        // Failed chaining
        if (!$this->issetCheck()) $this->throwError('Failed chaining!', 'chainingFailed');

        if (!class_exists('ZipArchive')) $this->throwError('Zein need Zip extension. Please install it first!', 'zipExtension');

        return $this;
    }

    public function directoryPermission(): Core
    {
        // Failed chaining
        if (!$this->issetCheck()) $this->throwError('Failed chaining!', 'chainingFailed');

        // Directory List
        $Directory = [SB . 'files/cache/', SB . 'admin/admin_template/'];

        $NotWrite = [];
        foreach ($Directory as $directory) {
            if (!is_writable($directory))
            {
                $NotWrite[] = $directory . ' is not writeable! This directory needed to make Zein works';
            }
        }

        if (count($NotWrite)) $this->throwError(implode(' <br> ', $NotWrite), 'DirectoryPermission');

        return $this;
    }

    public function device(): Core
    {
        // Failed chaining
        if (!$this->issetCheck()) $this->throwError('Failed chaining!', 'chainingFailed');

        if (utility::isMobileBrowser()) $this->throwError('Zein is not for mobile device!', 'MobileDevice');

        return $this;
    }

    public function result()
    {
        // Set pre define variable
        global $dbs,$sysconf;
        $page_title = 'Zein Error';

        if (count($this->Error))
        {
            ob_start();
            $ErrorMessage = '<ul>';
            foreach ($this->Error as $Error) {
                $ErrorMessage .= '<li class="font-weight-bold">' . $Error . '</li>';
            }
            $ErrorMessage .= '</ul>';
            $ErrorMessage .= <<<HTML
                <a href="logout.php" class="btn btn-danger">Logout</a>
            HTML;
            Alert::render('Zein Error', $ErrorMessage);
            $content = ob_get_clean();

            require SB . 'admin/admin_template/printed_page_tpl.php';
            exit;
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$Instance))
        {
            self::$Instance = new Core;
        }

        return self::$Instance;
    }
}