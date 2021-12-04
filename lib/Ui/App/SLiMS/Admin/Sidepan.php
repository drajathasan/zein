<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-02 10:07:30
 * @modify date 2021-12-02 10:07:30
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui\App\SLiMS\Admin;

use Zein\Ui\Html\Element;

class Sidepan
{
    public const ICON = [
        'bibliography' => 'mdi mdi-bookshelf',
        'circulation' => 'mdi mdi-arrow-decision',
        'membership' => 'mdi mdi-account-multiple',
        'master_file' => 'mdi mdi-database-edit',
        'stock_take' => 'mdi mdi-text-box-search',
        'system' => 'mdi mdi-cog',
        'reporting' => 'mdi mdi-file-table',
        'serial_control' => 'mdi mdi-qrcode',
        '*' => 'mdi mdi-toy-brick'
    ];

    private static function moduleList()
    {
        $List = '<li class="active"><a href="'. AWB .'index.php"  class="d-block w-full"><i class="mdi mdi-view-dashboard"></i> ' . __('Home') . '</a></li>';
        foreach ($_SESSION['priv'] as $Module => $Priv) {
            $ModuleTranslate = __(ucwords(str_replace('_', ' ', $Module)));
            if ($Priv['r']) $List .= '<li><a href="'. AWB .'index.php?mod=' . $Module . '"  class="d-block w-full"><i class="' . (self::ICON[$Module]??self::ICON['*']) . '"></i> ' . $ModuleTranslate . '</a></li>';
        }
        return $List;
    }

    private static function submenu(string $Module)
    {
        $ModuleTranslate = __(ucwords(str_replace('_', ' ', $Module)));

        // Other Module
        $List = Element::create('li', ['class' => 'notAJAX'], 
                    Element::create('a', ['href' => $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'], 'class' => 'd-block w-full'], 
                        Element::create('i', ['class' => (self::ICON['*'])]) . 'Modul Lain'));
        
        // Current module name
        $List .= Element::create('li', ['class' => 'active'], 
                    Element::create('a', ['href' => $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'], 'class' => 'd-block w-full'], 
                        Element::create('i', ['class' => (self::ICON[$Module]??self::ICON['*'])]) . $ModuleTranslate));

        // Include submenu
        if (file_exists($Submenu = MDLBS . $Module . '/submenu.php'))
        {
            $dbs = \SLiMS\DB::getInstance('mysqli');
            include $Submenu;
            $ActiveIndex = 'active';
            foreach ($menu as $ModuleMenu) {
                if ($ModuleMenu[0] === 'Header')
                {
                    $List .= Element::create('span', ['class' => 'd-block px-3 py-2 font-weight-bold text-muted'], __($ModuleMenu[1]));
                }
                else
                {
                    $List .= Element::create('li', ['class' => 'submenu ' . $ActiveIndex], Element::create('a', ['href' => $ModuleMenu[1], 'class' => 'd-block'], $ModuleMenu[0]));
                    $ActiveIndex = '';
                }
            }
        }
        return $List;
    }

    public static function render()
    {
        global $sysconf;
        
        $Class = '';
        if (isset($_GET['mod']))
        {
            $List = self::submenu($_GET['mod']);
            $Class = 'sidepan-at-module';
        }
        else
        {
            $List = self::moduleList();
        }

        $Logo = Logo::render(['class' => 'zein-slims-logo fill-current text-dark'], $sysconf);
        $LibraryName = $sysconf['library_name'];
        $HTML = <<<HTML
            <div class="sidepan flex {$Class}">
                <div class="h-screen">
                    <div onclick="window.location = 'index.php'" class="w-100 inst-logo d-flex justify-content-star cursor-pointer">
                        <div class="w-25 mr-2">
                            {$Logo}
                        </div>
                        <div class="w-50">
                            <h6 class="pl-2 mt-4 text-uppercase">{$LibraryName}</h5>
                        </div>
                    </div>
                    <ul class="mt-3 zein-side-nav">
                        {$List}
                    </ul>
                </div>
            </div>
        HTML;

        return $HTML;
    }
}