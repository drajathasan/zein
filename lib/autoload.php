<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-11-15 19:02:57
 * @modify date 2021-12-02 08:28:19
 * @license GPLv3
 * @desc [description]
 */

$Namespace = [
    'Zein\\' => DS,
    'View\\' => DS . '..' . DS
];

spl_autoload_register(function($class) use($Namespace) {
    foreach ($Namespace as $Prefix => $ClassPath) {
        $paths = explode('\\', $class);
        if (!isset($Namespace[$paths[0] . '\\'])) continue;
        unset($paths[0]);

        $fixPath = [];
        foreach ($paths as $index => $path) {
            if ($index === 0)
            {
                $fixPath[] = ucfirst($path);
            }
            else
            {
                $fixPath[] = ucfirst($path);
            }
        }

        $truePath = __DIR__ . $ClassPath . implode(DS, $fixPath) . '.php';

        if (file_exists($truePath))
        {
            include $truePath;
        }
    }
});