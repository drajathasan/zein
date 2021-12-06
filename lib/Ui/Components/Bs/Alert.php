<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-06 13:59:05
 * @modify date 2021-12-06 13:59:05
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui\Components\Bs;

use Zein\Ui\Html\Element;

class Alert
{
    public static function render()
    {
        echo Element::create('div', ['class' => 'alert alert-danger'], 
                Element::create('h3', ['class' => 'font-weight-bold'], 'Not Found') . 
                Element::create('p', [], 'View is not found!'));
    }
}