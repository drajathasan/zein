<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-02 20:43:34
 * @modify date 2021-12-02 20:43:34
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui\App\SLiMS\Admin;

use Zein\Ui\Html\Element;

class Header
{
    public static function userProfile()
    {
        if (file_exists(SB . 'images' . DS . 'persons' . DS . $_SESSION['upict']))
        {
            return SWB . 'images/persons/' . $_SESSION['upict'];
        }

        return SWB . 'images/persons/photo.png';
    }

    private static function dropDownMenu()
    {
        $Menus = [
            [__('Template Settings'), AWB . 'index.php/zein/colorscheme', 'mdi mdi-cogs'],
            [__('Change User Profiles'), MWB.'system/app_user.php?changecurrent=true&action=detail', 'mdi mdi-account'],
            [__('Logout'), AWB . 'logout.php', 'mdi mdi-exit-to-app']
        ];

        $Html = '';
        foreach ($Menus as $Menu) { 
            $Html .=  Element::create('a', ['class' => 'dropdown-item', 'href' => $Menu[1]], Element::create('i', ['class' => $Menu[2] . ' pr-2']) . $Menu[0]); 
        }

        return $Html;
    }

    public static function render()
    {
        $PhotoUrl = self::userProfile();
        $DropDown = self::dropDownMenu();
        $UserName = ucwords($_SESSION['realname']);
        $HTML = <<<HTML
            <div class="header-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="search-menu p-2 w-50 rounded-pill bg-white dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    <input class="pl-3 zein-search-input" placeholder="Search"/>
                                </div>
                                <div class="dropdown-menu dropdown-menu-left search-target mt-2" aria-labelledby="dropdownMenuButton">
                                    <div class="px-2">
                                        ....
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-6 zein-cursor-pointer">
                            <div class="d-flex justify-content-end dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    <img src="{$PhotoUrl}" class="zein-photo-profile rounded-circle">
                                    <span class="text-white zein-username font-weight-bold">{$UserName}</span>
                                </div>
                                <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="dropdownMenuButton">
                                    {$DropDown}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        HTML;

        return $HTML;
    }
}