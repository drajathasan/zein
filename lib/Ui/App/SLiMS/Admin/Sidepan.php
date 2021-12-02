<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-02 10:07:30
 * @modify date 2021-12-02 10:07:30
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui\App\SLiMS\Admin;

class Sidepan
{
    private static function moduleList()
    {
        $List = '';
        foreach ($_SESSION['priv'] as $Module => $Priv) {
            $Module = __(ucwords(str_replace('_', ' ', $Module)));
            if ($Priv['r'] && $Priv['w']) $List .= '<li><a href="'. AWB .'index.php?module=' . $Module . '"  class="d-block w-full">' . $Module . '</a></li>';
        }
        return $List;
    }

    public static function render()
    {
        $List = self::moduleList();
        $HTML = <<<HTML
            <div class="sidepan flex">
                <div class="h-screen">
                    <div class="w-100 inst-logo">

                    </div>
                    <ul class="overflow-auto">
                        {$List}
                    </ul>
                </div>
            </div>
        HTML;

        return $HTML;
    }
}