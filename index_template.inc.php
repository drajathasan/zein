<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-02 08:27:25
 * @modify date 2021-12-05 00:44:06
 * @license GPLv3
 * @desc Main Template File
 */

use Zein\{Http,Core};
use Zein\Ui\Html\Skeleton;
use Zein\Ui\App\SLiMS\Admin\{Logo,Dashboard,SearchMenu};

include __DIR__ . '/lib/autoload.php';
include __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/lib/helper.php';

// Zein Version
define('ZEIN_VERSION', '1.0.0');

// Dependency check
$Core = Core::getInstance();
$Core
    ->check()
    ->slimsVersion()
    ->directoryPermission()
    ->device()
    ->result();

// Render content based pathinfo
$Http = Http::getInstance();

$Http->getPath(function($Path) use($sysconf) {
    // View render
    if (count($Path) < 2)
    {
        Zein\View::render($Path[0], ['color' => $sysconf['admin_template']['config']['color']??'#007bff']);
        exit;
    }

    // For Crud process
    $Class = $Path[0];
    unset($Path[0]);
    $Param = [$sysconf, $Path];

    // Execute action
    callClass('Zein\Action\\' . $Class, function($Class) use($Param) {
        $Class::execute($Param[0], $Param[1]);
    });
});

// Create search menu
SearchMenu::getInstance()->generate();

// Html Skeleton
$Html = Skeleton::getInstance($sysconf);

// Load from cache if available
$Html->loadCache();

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
    // Start minify
    ->setMinify(true)
    ->setLink(['href' => $sysconf['admin_template']['css'], 'rel' => 'stylesheet', 'type' => 'text/css'])
    ->setLink(['href' => str_replace('style.css', 'css/custom.css', $sysconf['admin_template']['css']), 'rel' => 'stylesheet', 'type' => 'text/css'])
    // End minify
    ->setMinify(false)
    ->setLink(['href' => AWB . 'admin_template/' . $sysconf['admin_template']['theme'] . '/css/tui-chart.min.css', 'rel' => 'stylesheet', 'type' => 'text/css']);

// Custom Color
if (isset($sysconf['admin_template']['config'])):
    $Color = $sysconf['admin_template']['config']['color'];
    $Html->setStyle(['id' => 'customColor'], <<<HTML
            /** Sample **/
            ul.zein-side-nav > li.active {
                background-color: {$Color};
            }
            ul.zein-side-nav > li:hover {
                background-color: {$Color};
            }
            #zein-header, .dashboard-stat {
                background-color: {$Color} !important;
            }
            #cboxTitle {
                background-color: {$Color} !important;
            }
        HTML);
endif;

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
    ->setJs(['type' => 'text/javascript', 'src' => AWB . 'admin_template/' . $sysconf['admin_template']['theme'] . '/js/tui-chart-all.min.js'])
    ->setJs(['type' => 'text/javascript', 'src' => AWB . 'admin_template/' . $sysconf['admin_template']['theme'] . '/js/vanilla-picker.min.js'])
    ->setJs(['type' => 'text/javascript', 'src' => AWB . 'admin_template/' . $sysconf['admin_template']['theme'] . '/js/smooth-scrollbar.js'])
    ->setJs(['type' => 'text/javascript', 'src' => AWB . 'admin_template/' . $sysconf['admin_template']['theme'] . '/js/overscroll.js']);

// Translate
$TranslateJS = '
let barchart = ' . json_encode([__('Latest Transactions'), __('Loan'), __('Return'), __('Extend')]) . ';
let doughchart = ' . json_encode([__('Summary'), __('Total'), __('Loan'), __('Return'), __('Extend')]) . ';
';

$Html
    // Start minify
    ->setMinify(true)
    ->setJs(['type' => 'text/javascript'], $TranslateJS, 'Bottom')
    ->setJs(['type' => 'text/javascript', 'src' => AWB . 'admin_template/' . $sysconf['admin_template']['theme'] . '/js/app.js', 'name' => 'app', 'resturl' => SWB .'index.php?p=', 'startdate' => date('Y-m-d')], '', 'Bottom')
    // End minify
    ->setMinify(false);

/** End Head **/

// Set up view
$Param = ['maincontent' => Dashboard::render()];

// Submenu

// if get mod
if (isset($_GET['mod']) && !empty($_GET['mod'])) $Param['maincontent'] = preg_replace('/(.*)(\s+)(?=<script)/i', '', $sysconf['page_footer']);

// Render view
$View = Zein\View::render('mainlayout', $Param, true);

// zdd($_SESSION['priv']);
// Write Html Body
$Html->write($View);