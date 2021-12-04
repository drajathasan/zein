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
            [__('Change User Profiles'), MWB.'system/app_user.php?changecurrent=true&action=detail'],
            [__('Logout'), AWB . 'logout.php']
        ];

        $Html = '';
        foreach ($Menus as $Menu) { $Html .=  Element::create('a', ['class' => 'dropdown-item', 'href' => $Menu[1]], $Menu[0]); }

        return $Html;
    }

    public static function render()
    {
        $PhotoUrl = self::userProfile();
        $DropDown = self::dropDownMenu();
        $UserName = $_SESSION['realname'];
        $HTML = <<<HTML
            <div class="header-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-lg-5 col-xl-5">
                            <div class="search-menu p-2 w-75 rounded-pill bg-white">
                                <input class="pl-3 zein-search-input" placeholder="Search"/>
                            </div>
                        </div>
                        <div class="col-sm">
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-2 col-xl-2 zein-cursor-pointer dropdown">
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
        HTML;

        return $HTML;
    }
}