<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-11-15 19:12:00
 * @modify date 2021-12-02 09:40:47
 * @license GPLv3
 * @desc [description]
 */

namespace Zein;

class View
{
    private string $ViewDirectoryPath = __DIR__ . '/../view/';

    private function __construct(string $ViewDirectoryPath = '')
    {
        if (!empty($ViewDirectoryPath)) $this->ViewDirectoryPath = $ViewDirectoryPath;
    }

    public static function render(string $ViewName, array $Param = [], bool $Print = false, string $ViewPath = '')
    {
        global $PluginENV;
        $Instance = new static($ViewPath);
        $ViewName = str_replace('.', '', $ViewName); // no file inclusion attack :)
        
        ob_start();
        if (file_exists($Path = $Instance->ViewDirectoryPath . $ViewName . '.php'))
        {
            extract($Param);
            include $Path;
        }
        else
        {
            include $Instance->ViewDirectoryPath . 'notFound.php';
        }

        if ($Print) return ob_get_clean();
        echo ob_get_clean();
    }

    public static function instance(string $ViewPath = '')
    {
        return new View($ViewPath);
    }
}