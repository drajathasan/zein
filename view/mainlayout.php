<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-02 23:10:45
 * @modify date 2021-12-02 23:10:45
 * @license GPLv3
 * @desc [Main layout]
 */

use Zein\Ui\Html\Element;
use Zein\Ui\App\SLiMS\Admin\{Sidepan,Header};
use Zein\Ui\Components\Bs\Card;

defined('INDEX_AUTH') or die('No direct access!');

// Statistic card
$CardContent = [
    ['label' => __('Total of Collections'), 'icon' => Element::create('div', ['class' => 'rounded-circle', 'data-stat' => 'icon-collection'],  Element::create('i', ['class' => 'zein-stat-icon mdi mdi-book'])), 'sublabel' => __('Title')],
    ['label' => __('Total of Items'), 'icon' => Element::create('div', ['class' => 'rounded-circle', 'data-stat' => 'icon-item'],  Element::create('i', ['class' => 'zein-stat-icon mdi mdi-content-copy'])), 'sublabel' => __('Item')],
    ['label' => __('Lent'), 'icon' => Element::create('div', ['class' => 'rounded-circle', 'data-stat' => 'icon-lent'],  Element::create('i', ['class' => 'zein-stat-icon mdi mdi-arrow-right-circle'])), 'sublabel' => __('Item')],
    ['label' => __('Available'), 'icon' => Element::create('div', ['class' => 'rounded-circle', 'data-stat' => 'icon-available'],  Element::create('i', ['class' => 'zein-stat-icon mdi mdi-checkbox-marked-circle'])), 'sublabel' => __('Item')]
];

// Output area
ob_start();

// Header
echo Element::create('header', ['id' => 'zein-header', 'class' => 'py-3 px-2 bg-primary'], Header::render());

// Statistic
if (!isset($_GET['mod'])):
    echo Element::create('div', ['class' => 'w-100 h-50 dashboard-stat bg-primary'], 
                      Element::create('div', ['class' => 'mt-3 inner-stat'], 
                      Card::deck($CardContent)));
endif;
// Navbar
echo Element::create('nav', ['id' => 'zein-nav ', 'class' => 'position-fixed'], Sidepan::render());
// Loader
echo Element::create('div', ['class' => 'loader d-none', 'style' => 'display: none']);
// Main Content
$ContentClass = isset($_GET['mod']) ? 'rounded' : 'mainContentDashboard rounded';
echo Element::create('div', ['id' => 'mainContent', 'class' => $ContentClass], $maincontent??'');
// Iframe
echo Element::create('iframe', ['name' => 'blindSubmit', 'style' => 'display: none; visibility: hidden; width: 0; height: 0;']);

// Get buffer
echo ob_get_clean();