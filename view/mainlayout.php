<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-02 23:10:45
 * @modify date 2021-12-02 23:10:45
 * @license GPLv3
 * @desc [description]
 */

use Zein\Ui\Html\Element;
use Zein\Ui\App\SLiMS\Admin\{Sidepan,Header};
use Zein\Ui\Components\Bs\Card;

defined('INDEX_AUTH') or die('No direct access!');

// Statistic card
$CardContent = [
    ['label' => __('Total of Collections'), 'icon' => '', 'sublabel' => __('Title')],
    ['label' => __('Total of Items'), 'icon' => '', 'sublabel' => __('Item')],
    ['label' => __('Lent'), 'icon' => '', 'sublabel' => __('Item')],
    ['label' => __('Available'), 'icon' => '', 'sublabel' => __('Item')]
];

// Output
ob_start();

echo Element::create('header', ['id' => 'zein-header', 'class' => 'py-3 px-2 bg-primary'], Header::render());
// Statistic
echo Element::create('div', ['class' => 'w-100 h-50 dashboard-stat bg-primary'], 
                      Element::create('div', ['class' => 'mt-3 inner-stat'], 
                      Card::deck($CardContent)));
// Navbar
echo Element::create('nav', ['id' => 'zein-nav ', 'class' => 'position-fixed'], Sidepan::render());
// Loader
echo Element::create('div', ['class' => 'loader d-none', 'style' => 'display: none']);
// Main Content
echo Element::create('div', ['id' => 'mainContent', 'class' => 'mainContentDashboard rounded']);

// Get buffer
echo ob_get_clean();