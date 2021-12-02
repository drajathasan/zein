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

class Header
{
    public static function render()
    {
        $PhotoUrl = SWB . 'images/persons/photo.png';
        $UserName = $_SESSION['realname'];
        $HTML = <<<HTML
            <div class="header-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm">
                            <div class="search-menu p-2 w-75 rounded-pill bg-white">
                                <input class="pl-3 zein-search-input" placeholder="Search"/>
                            </div>
                        </div>
                        <div class="col-sm">
                        </div>
                        <div class="col-xs zein-cursor-pointer dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                <img src="{$PhotoUrl}" class="zein-photo-profile rounded-circle">
                                <span class="text-white zein-username font-weight-bold">{$UserName}</span>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        HTML;

        return $HTML;
    }
}