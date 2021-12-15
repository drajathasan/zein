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
use Zein\Ui\Html\{Element,Skeleton};
use Zein\Ui\App\SLiMS\Admin\SearchMenu;
use SLiMS\DB;

class Search
{
    private static $Instance = null;
    private $Conf;
    private $Path;

    private function __construct(array $Conf)
    {
        $this->Conf = $Conf;
    }

    public function menu()
    {
        SearchMenu::find($_GET['keyword']);
    }

    public static function execute(array $Conf, array $Path)
    {
        if (is_null(self::$Instance))
        {
            self::$Instance = new Search($Conf);
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