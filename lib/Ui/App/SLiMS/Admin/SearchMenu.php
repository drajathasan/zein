<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-14 11:50:35
 * @modify date 2021-12-14 11:50:35
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui\App\SLiMS\Admin;

use SLiMS\{Plugins,DB};

class SearchMenu
{
    private static $Instance = null;

    private function __construct(){}

    public function generate()
    {
        if (!isset($_SESSION['searchMenu']))
        {
            $dbs = DB::getInstance('mysqli');
            $Menu = [];
            foreach ($_SESSION['priv'] as $Module => $Priv) {
                $ModuleTranslate = __(ucwords(str_replace('_', ' ', $Module)));
                if ($Priv['r'] && file_exists($Submenu = MDLBS . $Module . '/submenu.php')) {
                    include_once $Submenu;
                    // Set menu list
                    $Menu[$ModuleTranslate] = array_filter($menu, function($Menu){
                        if ($Menu[0] !== 'Header')
                        {
                            return $Menu;
                        }
                    });

                    $Plugins = $this->plugins($Module, $_SESSION['priv'][$Module]['menus']??[]);
                    $Menu[$ModuleTranslate] = array_merge($Menu[$ModuleTranslate], $Plugins);
                }
            }
            $_SESSION['searchMenu'] = $Menu;
        }
    }

    public static function find(string $Keyword)
    {
        $Result = [];
        if (empty($Keyword)) \Zein\Http::responseJson($Result);

        foreach ($_SESSION['searchMenu'] as $ModuleName => $Menu) {
            for ($i=0; $i < count($_SESSION['searchMenu'][$ModuleName]); $i++) { 
                $Submenu = $_SESSION['searchMenu'][$ModuleName][$i];
                // Keyword match
                if (preg_match('/'.$Keyword.'/i', $Submenu[0]))
                {
                    // Get module name : (
                    preg_match('/(?<=plugin_container.php)(.*)/', $Submenu[1], $Match);
                    if (isset($Match[0])) 
                    {
                        $Submenu[(array_key_last($Submenu) + 1)] = str_replace('mod=', '', explode('&', trim($Match[0], '?'))[0]);
                    }
                    else
                    {
                        // unset tooltips
                        unset($Submenu[2]);
                        $Submenu[(array_key_last($Submenu) + 1)] = basename(dirname($Submenu[1]));
                    }

                    $Result[$Submenu[0]] = $Submenu;
                }
            }
        }

        \Zein\Http::responseJson(array_values($Result));
    }

    public function plugins(string $ModuleName, array $SubmenuPrivileges)
    {
        // Get Plugin list
        $PluginBaseModule = array_values(Plugins::getInstance()->getMenus($ModuleName));

        // null for empty list
        if (!count($PluginBaseModule)) return [];

        // Set element list
        $List = [];

        $PluginValid = 0;
        foreach ($PluginBaseModule as $Index => $Plugin) {
            // Check if next data have child (Submenu Permission)
            $haveChild = count($SubmenuPrivileges) < 1 || (isset($PluginBaseModule[$Index + 1]) && in_array(md5($PluginBaseModule[$Index + 1][1]), $SubmenuPrivileges));

            if (count($SubmenuPrivileges) < 1 || in_array(md5($Plugin[1]), $SubmenuPrivileges))
            {
                // create first submenu
                $List[] = [$Plugin[0], $Plugin[1]];
                
                // Increate number
                $PluginValid++;
            }
            else if (!$haveChild)
            {
                continue;
            }
        }

        // check plugin is exists or not
        if ($PluginValid < 1) return [];
        
        return $List;
    }

    public static function getInstance()
    {
        if (is_null(self::$Instance))
        {
            self::$Instance = new SearchMenu;
        }

        return self::$Instance;
    }
}