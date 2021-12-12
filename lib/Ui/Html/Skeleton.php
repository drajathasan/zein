<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-01 20:18:49
 * @modify date 2021-12-05 00:49:06
 * @license MIT
 * @desc [description]
 */

namespace Zein\Ui\Html;

use Zein\Ui\Tool;

class Skeleton
{
    private static $Instance = null;
    private $Minify = false;
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

    public function setMinify(bool $Status)
    {
        $this->Minify = $Status;
        return $this;
    }

    public function setJs(array $Attribute, string $Slot = '', string $Position = 'Head')
    {
        // minified it?
        if ($this->Minify && isset($Attribute['src']))
        {
            $ModifiedAttribute = $Attribute;
            Tool::minify(dirname(str_replace(AWB, SB . 'admin' . DS, $ModifiedAttribute['src'])), basename($ModifiedAttribute['src']));
            $Attribute['src'] = str_replace('.js', '.min.js', $Attribute['src']);
        }
        // Mutating
        if (isset($Attribute['src']) && !preg_match('/.min.js/i', $Attribute['src'])) $Attribute['src'] = $Attribute['src'] . '?v=' . date('this');
        $this->$Position['js'][] = Element::create('script', $Attribute, $Slot);

        return $this;
    }

    public function setLink(array $Attribute)
    {
        // minified it?
        if ($this->Minify && isset($Attribute['href']))
        {
            $ModifiedAttribute = $Attribute;
            Tool::minify(dirname(str_replace(AWB, SB . 'admin' . DS, $ModifiedAttribute['href'])), basename($ModifiedAttribute['href']));
            $Attribute['href'] = str_replace('.css', '.min.css', $Attribute['href']);
        }

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

    public function write(string $Content, array $Attribute = [])
    {
        // Start compression
        Tool::compress('start');

        // Start html tag
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

        // Write HTML
        echo Element::create('html', ['lang' => $this->Conf['default_lang']], $Head . $Body);

        // End compression
        $HTML = Tool::compress('end');

        // Make cache
        $this->makeCache($HTML);

        // Ouput
        echo $HTML;
    }

    private function makeCache(string $Html)
    {
        $id = (isset($_GET['mod']) && !empty($_GET['mod'])) ? $_GET['mod'] : 'dashboard';
        file_put_contents(SB . 'files/cache/zein-html-cache-' . $_SESSION['uid'] . '-' . $id . '.html', $Html);
    }

    public function loadCache()
    {
        $id = (isset($_GET['mod']) && !empty($_GET['mod'])) ? $_GET['mod'] : 'dashboard';
        $CachePath = SB . 'files/cache/zein-html-cache-' . $_SESSION['uid'] . '-' . $id . '.html';
        
        if (file_exists($CachePath))
        {
            // Start compression
            Tool::compress('start');
            echo file_get_contents($CachePath);
            // Compress end
            $Content = Tool::compress('end');

            // Setout cache
            exit($Content);
        }
    }

    public static function removeCache()
    {
        $CacheDir = array_diff(scandir(SB . 'files/cache/'), ['.','..']);

        foreach ($CacheDir as $CacheFile) {
            if (preg_match('/zein-html-cache-' . $_SESSION['uid'] . '/i', $CacheFile))
            {
                @unlink(SB . 'files/cache/' . $CacheFile);
            }
        }
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