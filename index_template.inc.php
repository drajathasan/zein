<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-02 08:27:25
 * @modify date 2021-12-05 00:44:06
 * @license GPLv3
 * @desc Main Template File
 */

use Zein\Http;
use Zein\Ui\Html\Skeleton;
use Zein\Ui\App\SLiMS\Admin\{Logo,Dashboard};

include __DIR__ . '/lib/autoload.php';
require __DIR__ . '/lib/helper.php';

// Mini Rest
$Http = Http::getInstance();
$Http->getPath();

// Html Skeleton
$Html = Skeleton::getInstance($sysconf);

/**  Head Element **/
// Meta
$Html
    ->setMeta(['charset' => 'utf-8'])
    ->setMeta(['name' => 'viewport', 'content' => 'width=device-width, height=device-height, initial-scale=1'])
    ->setMeta(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge'])
    ->setMeta(['http-equiv' => 'Content-Type', 'content' => 'text/html; charset=utf-8'])
    ->setMeta(['http-equiv' => 'Pragma', 'content' => 'no-cache'])
    ->setMeta(['http-equiv' => 'Cache-Control', 'content' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0'])
    ->setMeta(['http-equiv' => 'Expires', 'content' => 'Sat, 26 Jul 1997 05:00:00 GMT']);

// Fav ico
$Logo = Logo::loadFromConf($sysconf, [], 'src');

// Css
$Html
    ->setLink(['rel' => 'icon', 'href' => $Logo??SWB . 'webicon.ico', 'type' => 'image/x-icon'])
    ->setLink(['rel' => 'shortcut icon', 'href' => $Logo??SWB . 'webicon.ico', 'type' => 'image/x-icon'])
    ->setLink(['href' => SWB . 'css/bootstrap.min.css?' . date('this'), 'rel' => 'stylesheet', 'type' => 'text/css'])
    ->setLink(['href' => SWB . 'css/core.css?' . date('this'), 'rel' => 'stylesheet', 'type' => 'text/css'])
    ->setLink(['href' => JWB . 'colorbox/colorbox.css?' . date('this'), 'rel' => 'stylesheet', 'type' => 'text/css'])
    ->setLink(['href' => JWB . 'chosen/chosen.css?' . date('this'), 'rel' => 'stylesheet', 'type' => 'text/css'])
    ->setLink(['href' => JWB . 'toastr/toastr.min.css?' . date('this'), 'rel' => 'stylesheet', 'type' => 'text/css'])
    ->setLink(['href' => JWB . 'jquery.imgareaselect/css/imgareaselect-default.css', 'rel' => 'stylesheet', 'type' => 'text/css'])
    ->setLink(['href' => AWB . str_replace('style.css', 'css/materialdesignicons.min.css', $sysconf['admin_template']['css']), 'rel' => 'stylesheet', 'type' => 'text/css'])
    ->setLink(['href' => $sysconf['admin_template']['css'].'?'.date('this'), 'rel' => 'stylesheet', 'type' => 'text/css'])
    ->setLink(['href' => str_replace('style.css', 'css/custom.css', $sysconf['admin_template']['css']) .'?'.date('this'), 'rel' => 'stylesheet', 'type' => 'text/css'])
    ->setStyle([], <<<HTML
        /*ul.zein-side-nav > li.active {
            background-color: black;
        }
        ul.zein-side-nav > li:hover {
            background-color: black;
        }
        #zein-header, .dashboard-stat {
            background-color: black !important;
        }
        #cboxTitle {
            background-color: black !important;
        }*/
    HTML);

// JS
$Html
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'jquery.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'updater.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'gui.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'form.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'calendar.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'chosen/chosen.jquery.min.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'chosen/ajax-chosen.min.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'ckeditor/ckeditor.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'tooltipsy.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'colorbox/jquery.colorbox-min.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'jquery.imgareaselect/scripts/jquery.imgareaselect.pack.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'webcam.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'scanner.js'])
    ->setJs(['type' => 'text/javascript', 'src' => SWB . 'js/popper.min.js'])
    ->setJs(['type' => 'text/javascript', 'src' => SWB . 'js/bootstrap.min.js'])
    ->setJs(['type' => 'text/javascript', 'src' => JWB . 'toastr/toastr.min.js'])
    ->setJs(['type' => 'text/javascript', 'src' => AWB . 'admin_template/' . $sysconf['admin_template']['theme'] . '/js/smooth-scrollbar.js'])
    ->setJs(['type' => 'text/javascript', 'src' => AWB . 'admin_template/' . $sysconf['admin_template']['theme'] . '/js/overscroll.js'])
    ->setJs(['type' => 'text/javascript', 'src' => AWB . 'admin_template/' . $sysconf['admin_template']['theme'] . '/js/app.js'], '', 'Bottom');

/** End Head **/

// Set up view
$Param = ['maincontent' => Dashboard::render()];
if (isset($_GET['mod']) && !empty($_GET['mod'])) $Param = ['maincontent' => preg_replace('/(.*)(\s+)(?=<script)/i', '', $sysconf['page_footer'])];

// Render view
$View = Zein\View::render('mainlayout', $Param, true);

// zdd($_SESSION['priv']);
// Write Html Body
$Html->write($View);