<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-07 10:56:26
 * @modify date 2021-12-07 10:56:26
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui\Components\Bs;

use Zein\Ui\Html\Element;

class HorizontalForm extends Form
{
    private static $Instance = null;

    private function __construct()
    {
    }

    public function Group(string $Label, $Element)
    {
        $this->Field[] = Element::create('div', ['class' => 'form-group row my-2'],
            Element::create('label', ['class' => 'col-sm-2 col-form-label'], $Label) .
            Element::create('div', ['class' => 'col-sm-10'], 
                (is_array($Element) ? Element::create($Element['type'], $Element['attribute'], $Element['slot']??'') : $Element)
            )
        );

        return $this;
    }

    public static function getInstance()
    {
        if (is_null(self::$Instance))
        {
            self::$Instance = new HorizontalForm;
        }

        return self::$Instance;
    }
}