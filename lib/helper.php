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

if (!function_exists('callClass'))
{
    function callClass(string $Class, Closure $Callback)
    {
        if (class_exists($Class))
        {
            $Callback($Class);
        }
        else
        {
            echo 'Action not found!';
        }
    }
}

if (!function_exists('simbioChangeParam'))
{
    function simbioChangeParam(string $Simbio, string $ChangeWith)
    {
        return preg_replace('/(?<=simbioAJAX\(\')(.*)(?=\',)/i', $ChangeWith, $Simbio);
    }
}

if (!function_exists('zeinUrl'))
{
    function zeinUrl(string $AdditionalPath = '')
    {
        global $sysconf;
        return AWB . $sysconf['admin_template']['dir'].'/'.$sysconf['admin_template']['theme'] . '/' . $AdditionalPath;
    }
}

/**
 * Recursively empty and delete a directory
 * 
 * @param string $path
 * @ref https://gist.github.com/jmwebservices/986d9b975eb4deafcb5e2415665f8877
 */

if (!function_exists('rrmdir'))
{
    function rrmdir( string $path ) : void
    {

        if( trim( pathinfo( $path, PATHINFO_BASENAME ), '.' ) === '' )
            return;

        if( is_dir( $path ) )
        {
            array_map( 'rrmdir', glob( $path . DIRECTORY_SEPARATOR . '{,.}*', GLOB_BRACE | GLOB_NOSORT ) );
            @rmdir( $path );
        }

        else
            @unlink( $path );

    }
}