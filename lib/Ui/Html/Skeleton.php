<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-01 20:18:49
 * @modify date 2021-12-01 20:18:49
 * @license MIT
 * @desc [description]
 */

namespace Zein\Ui\Html;

class Skeleton
{
    private static $Instance = null;
    public $Conf = [];
    public $Head = [];
    public $AssetPath = '';
    public $ViewPath = '';

    private function __construct(array $Conf, string $AssetPath, string $ViewPath)
    {
        $this->Conf = $Conf;
        $this->AssetPath = $AssetPath;
        $this->ViewPath = $ViewPath;
    }

    public function setMeta(array $Attribute)
    {
        Element::$Close = false;
        $this->Head['meta'][] = Element::create('meta', $Attribute);
        Element::$Close = true;

        return $this;
    }

    public function setJs(array $Attribute, string $Slot = '', string $Position = 'Head')
    {
        $Attribute['src'] = $Attribute['src'] . '?v=' . date('this');
        $this->$Position['js'][] = Element::create('script', $Attribute, $Slot);

        return $this;
    }

    public function setLink(array $Attribute)
    {
        Element::$Close = false;
        $this->Head['link'][] = Element::create('link', $Attribute);
        Element::$Close = true;

        return $this;
    }

    public function setStyle(array $Attribute, string $Slot)
    {
        $this->Head['style'][] = Element::create('style', $Attribute, $Slot);

        return $this;
    }

    public function setBootstrapCss(array $Filename)
    {
        
    }

    public function write(string $Content, array $Attribute = [])
    {
        $Html = '<!DOCTYPE Html>';
        
        // Head element
        $innerHead = Element::create('title', [], $this->Conf['library_name'] . ' :: ' . $this->Conf['library_subname']);
        foreach ($this->Head as $HeadElement) {
            $innerHead .= implode('', $HeadElement);
        }
        $Head = Element::create('head', [], $innerHead);
        // end head
        
        // Bottom JS
        $BottomJS = '';
        foreach ($this->Bottom['js']??[] as $Js) {
            $BottomJS .= $Js;
        }

        // Body
        $Body = Element::create('body', $Attribute, $Content . $BottomJS);
        // end body

        echo Element::create('html', ['lang' => $this->Conf['default_lang']], $Head . $Body);
    }

    public static function getInstance(array $Conf, string $AssetPath = '', string $ViewPath = '')
    {
        if (is_null(self::$Instance))
        {
            self::$Instance = new Skeleton($Conf, $AssetPath, $ViewPath);
            return self::$Instance;
        }

        return self::$Instance;
    }
}