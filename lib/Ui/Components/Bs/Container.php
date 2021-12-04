<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-04 08:04:55
 * @modify date 2021-12-04 08:04:55
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui\Components\Bs;

use Zein\Ui\Html\Element;

class Container
{
    public const TYPE = [
        'container', 'container-sm', 'container-md',
        'container-lg', 'container-xl', 'container-fluid'
    ];
    private $Row = [];
    private $Col = [];
    public $Type = '';
    
    public static function init(string $Type = '')
    {
        $Container = new Static();
        $Type = (empty($Type)) ? 'container' : 'container-' . $Type;

        if (!in_array($Type, self::TYPE)) die('Uknown container type.');

        // Make container
        $Container->Type = $Type;

        return $Container;
    }

    public function row(string $AdditionalClass = '')
    {
        if (!empty($AdditionalClass)) $this->Row['class'] = $AdditionalClass;
        return $this;
    }

    public function col(array $ColData)
    {
        $this->Row['num'] = count($ColData);
        $this->Col = $ColData;

        return $this;
    }

    public function create()
    {
        $Html = '';
        for ($Row=0; $Row < $this->Row['num']; $Row++) { 
            $Slot = '';
            for ($slot=0; $slot < count($this->Col['content']); $slot++) { 
                $Col  = $this->Col['content'][$slot];
                $Slot .= Element::create('div', ['class' => $Col['class']], $Col['slot']);
            }
            $Html .= Element::create('div', ['class' => 'row ' . ($this->Row['class']??'')], $Slot);
        }

        return Element::create('div', ['class' => $this->Type], $Html);
    }
}