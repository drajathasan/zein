<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-07 11:01:30
 * @modify date 2021-12-07 11:01:30
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui\Components\Bs;

use Zein\Ui\Html\Element;

abstract class Form
{
    protected $Field = [];
    private $Attribute = [];

    public function setMethod(string $Method)
    {
        $this->Attribute['method'] = $Method;
        return $this;
    }

    public function setAction(string $Action)
    {
        $this->Attribute['action'] = $Action;
        return $this;
    }

    public function setTarget(string $Target)
    {
        $this->Attribute['target'] = $Target;
        return $this;
    }

    public function setAttribute()
    {
        $Argument = func_get_args();
        
        if (func_num_args() === 1)
        {
            $this->Attribute = array_merge($this->Attribute, $Argument[0]);
        }
        else
        {
            $this->Attribute[$Argument[0]] = $Argument[1];
        }

        return $this;
    }

    public function setTitle(string $Title)
    {
        $this->Field[] = Element::create('h3', [], $Title);

        return $this;
    }

    public function setField(array $Element)
    {
        $this->Field[] = Element::create($Element['type'], $Element['attribute'], $Element['slot']);
        return $this;
    }

    public function setSubmitButton(string $Label = 'Save', array $Attribute = ['class' => 'btn btn-primary'])
    {
        $this->Field[] = Element::create('button', $Attribute, $Label);
        return $this;
    }

    public function create()
    {
        return Element::create('form', $this->Attribute, implode('', $this->Field));
    }
}