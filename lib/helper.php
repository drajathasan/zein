<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-02 12:06:11
 * @modify date 2021-12-02 12:06:11
 * @license GPLv3
 * @desc [description]
 */

if (!function_exists('zdd'))
{
    function zdd($Mix, bool $Close = true)
    {
        echo '<pre>';
        var_dump($Mix);
        echo '</pre>';

        if ($Close) exit;
    }
}