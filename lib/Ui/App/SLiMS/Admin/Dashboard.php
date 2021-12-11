<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-02 20:41:43
 * @modify date 2021-12-02 20:41:43
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui\App\SLiMS\Admin;

use Zein\Ui\Components\Bs\Container;
use Zein\Ui\Html\Element;

class Dashboard
{
    public static function render()
    {
        $Slot = [
            'content' => [
                [
                    'class' => 'col-sm-12 col-md-8 col-lg-8',
                    'slot' => Element::create('div', ['class' => 'statistic bg-white px-3 py-2', 'id' => 'transactionState'])
                ],
                [
                    'class' => 'col-sm-12 col-md-4 col-lg-4',
                    'slot' => Element::create('div', ['class' => 'statistic bg-white px-3 py-2', 'id' => 'collectionStat'])
                ]
            ]
        ];

        return Container::init('fluid')->row()->col($Slot)->create();
    }
}