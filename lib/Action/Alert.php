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

use Zein\Ui\App\SLiMS\Admin\Header;
use Zein\Http;

class Alert
{
    private static $Instance = null;
    private $Conf;
    private $Path;

    private function __construct(array $Conf)
    {
        $this->Conf = $Conf;
    }

    public function generate()
    {
        Http::responseJson(Header::alertBell());
    }

    public static function execute(array $Conf, array $Path)
    {
        if (is_null(self::$Instance))
        {
            self::$Instance = new Alert($Conf);
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