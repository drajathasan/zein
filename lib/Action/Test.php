<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-21 14:32:32
 * @modify date 2021-12-21 14:32:32
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Action;

use Zein\Http;

class Test
{
    private static $Instance = null;

    public function download()
    {
        $Http = Http::getInstance();

        $Download = $Http
                    ->client('curl')
                    ->download('https://github.com/drajathasan/slims-tarsius/archive/refs/heads/master.zip', SB . 'files/cache/tarsius-curl.zip');

        zdd($Download->getResult());
    }

    public static function execute(array $Conf, array $Path)
    {
        if (is_null(self::$Instance))
        {
            self::$Instance = new Test($Conf);
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