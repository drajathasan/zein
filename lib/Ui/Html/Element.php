<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-01 17:35:47
 * @modify date 2021-12-05 00:47:11
 * @license MIT
 * @desc [description]
 */

 namespace Zein\Ui\Html;

 class Element
 {
     public const HTMLTag = [
     'a','abbr','acronym','address','applet',
     'area','article','aside','audio','b','base','basefont','bdi','bdo','big','blockquote','body',
     'br','button','canvas','caption','center','cite','code','col','colgroup','data','datalist','dd','del','details','dfn',
     'dialog','dir','div','dl','dt','em','embed','fieldset','figcaption','figure','font','footer','form','frame',
     'frameset','h1', 'h6','head','header','hr','html','i','iframe','img','input','ins','kbd','label','legend',
     'li','link','main','map','mark','meta','meter','nav','noframes','noscript','object','ol','optgroup',
     'option','output','p','param','picture','pre','progress','q','rp','rt','ruby','s','samp','script','section',
     'select','small','source','span','strike','strong','style','sub','summary','sup','svg','table','tbody','td',
     'template','textarea','tfoot','th','thead','time','title','tr','track','tt','u','ul','var','video','wbr', 
     'h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
     public static $Close = true;

     public static function create(string $Tag, array $Attributes = [], string $Slot = '') :string
     {
        if (!in_array($Tag, self::HTMLTag)) die($Tag . ' is not valid HTML tag');

        $El = '<' . self::free($Tag);

        if (count($Attributes))
        {
            $El .= ' ' . self::arrayAttribute($Attributes);
        }

        $El .= (self::$Close) ? '>' . $Slot . '</' . self::free($Tag) . '>' : '/>' ;

        return $El;
     }

     public static function free(string $Element)
     {
        return preg_replace('/[^A-Za-z\-0-9]/i', '', strtolower($Element));
     }

     public static function noquote(string $Value)
     {
        return str_replace(['"','`','\''], '', $Value);
     }

     public static function arrayAttribute(array $Attributes)
     {
        return trim(implode(' ', array_map(function($value, $key) {
            return self::free(trim($key)) . '="' . self::noquote(trim($value)) . '"';
        }, array_values($Attributes), array_keys($Attributes))));
     }
 }