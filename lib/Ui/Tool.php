<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-07 13:23:43
 * @modify date 2021-12-11 13:23:43
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui;

use MatthiasMullie\Minify;

class Tool
{
    public static function minify(string $Path, string $Filename)
    {
        $FileInfo = pathinfo($Filename);
        $Class = 'MatthiasMullie\Minify\\' . strtoupper($FileInfo['extension']);
        
        if (class_exists($Class))
        {
            $minifier = new $Class($Path . DS . $Filename);
            // Save
            $minifier->minify($Path . DS . $FileInfo['filename'] . '.min.' . $FileInfo['extension']);
        }
    }
}