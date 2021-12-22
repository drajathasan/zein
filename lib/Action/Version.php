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

use Zein\Http;

class Version
{
    private static $Instance = null;

    private static function checkUpdate()
    {
        $Http = Http::getInstance();

        
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