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
use SLiMS\DB;

class Config
{
    private static $Instance = null;
    private $Conf;
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
        Skeleton::removeCache();

        echo Element::create('script', [], 'setTimeout(() => {parent.window.location = "' . AWB . '"}, 5000)');
        \utility::jsToastr('Data has been saved', 'Success', 'success');
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