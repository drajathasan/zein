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
use SLiMS\Plugins;

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

    private static function moduleList(bool $Hidden = false)
    {
        // Home
        $List = Element::create('li', ['class' => (($Hidden) ? 'module-list d-none' : 'active')],
                    Element::create('a', ['href' => AWB .'index.php', 'class' => 'd-block w-full'],
                        Element::create('i', ['class' => 'mdi mdi-view-dashboard']) . ' ' . __('Home')));
        
        // Module list
        foreach ($_SESSION['priv'] as $Module => $Priv) {
            $ModuleTranslate = __(ucwords(str_replace('_', ' ', $Module)));
            if ($Priv['r']) {
                $List .= Element::create('li', (($Hidden) ? ['class' => 'module-list d-none'] : []),
                            Element::create('a', ['href' => AWB .'index.php?mod=' . $Module, 'class' => 'd-block w-full'],
                                Element::create('i', ['class' => (self::ICON[$Module]??self::ICON['*'])]) . ' ' . $ModuleTranslate));
            }
        }
        return $List;
    }

    private static function submenu(string $Module, array $SubmenuPrivileges = [])
    {
        $ModuleTranslate = __(ucwords(str_replace('_', ' ', $Module)));

        // Other Module
        $List = Element::create('li', ['class' => 'other-module notAJAX'], 
                    Element::create('a', ['href' => $_SERVER['PHP_SELF'], 'class' => 'd-block w-full'], 
                        Element::create('i', ['class' => (self::ICON['*'])]) . 'Modul Lain'));
        
        // Current module name
        $List .= Element::create('li', ['class' => 'active submenu-header'], 
                    Element::create('a', ['href' => $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'], 'class' => 'd-block w-full'], 
                        Element::create('i', ['class' => (self::ICON[$Module]??self::ICON['*'])]) . $ModuleTranslate));

        // Include submenu
        if (file_exists($Submenu = MDLBS . $Module . '/submenu.php'))
        {
            // Make database instances
            $dbs = \SLiMS\DB::getInstance('mysqli');

            // Include submenu
            include $Submenu;

            // Set active 
            $ActiveIndex = 'active';

            // Generate submenu
            foreach ($menu as $Index => $ModuleMenu) {
                // Check if next data have child (Submenu Permission)
                $haveChild = count($SubmenuPrivileges) < 1 || (isset($menu[$Index + 1]) && in_array(md5($menu[$Index + 1][1]), $SubmenuPrivileges));

                if ($ModuleMenu[0] === 'Header')
                {
                    // unset data continue to next data 
                    if (!$haveChild) { unset($menu[$Index + 1]); continue; }

                    // Create header label
                    $List .= Element::create('span', ['class' => 'd-block px-3 py-2 font-weight-bold text-muted submenu-header'], __($ModuleMenu[1]));
                }
                // Submenu permission check
                else if (count($SubmenuPrivileges) < 1 || in_array(md5($ModuleMenu[1]), $SubmenuPrivileges))
                {
                    // create first submenu
                    $List .= Element::create('li', ['class' => 'submenu ' . $ActiveIndex], Element::create('a', ['href' => $ModuleMenu[1], 'class' => 'd-block'], $ModuleMenu[0]));
                    // Reset Active index
                    $ActiveIndex = '';
                }
            }
        }
        return $List;
    }

    public static function plugins(string $ModuleName, array $SubmenuPrivileges)
    {
        // Get Plugin list
        $PluginBaseModule = array_values(Plugins::getInstance()->getMenus($ModuleName));

        // null for empty list
        if (!count($PluginBaseModule)) return '';

        // Set element list
        $List = Element::create('span', ['class' => 'd-block px-3 py-2 font-weight-bold text-muted submenu-header'], 'Plugins');

        $PluginValid = 0;
        foreach ($PluginBaseModule as $Index => $Plugin) {
            // Check if next data have child (Submenu Permission)
            $haveChild = count($SubmenuPrivileges) < 1 || (isset($PluginBaseModule[$Index + 1]) && in_array(md5($PluginBaseModule[$Index + 1][1]), $SubmenuPrivileges));

            if (count($SubmenuPrivileges) < 1 || in_array(md5($Plugin[1]), $SubmenuPrivileges))
            {
                // create first submenu
                $List .= Element::create('li', ['class' => 'submenu'], Element::create('a', ['href' => $Plugin[1], 'class' => 'd-block'], $Plugin[0]));
                
                // Increate number
                $PluginValid++;
            }
            else if (!$haveChild)
            {
                continue;
            }
        }

        // check plugin is exists or not
        if ($PluginValid < 1) return '';
        
        return $List;
    }

    public static function render()
    {
        global $sysconf;
        
        $Class = '';
        $ModuleName = preg_replace('/[^A-Za-z_]/i', '', $_GET['mod']??'');
        if (!empty($ModuleName))
        {
            // Module List & submenu
            $List  = self::moduleList($Hidden = true);
            $List .= self::submenu($_GET['mod'], $_SESSION['priv'][$ModuleName]['menus']??[]);
            
            // Set custom plugin list
            $PluginList = self::plugins($ModuleName, $_SESSION['priv'][$ModuleName]['menus']??[]);
            if (!empty($PluginList)) $List .= $PluginList . Element::create('span', ['class' => 'd-block h-25']);

            // set class
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