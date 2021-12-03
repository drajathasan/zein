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
        $icon = [
            'bibliography' => 'mdi mdi-bookshelf',
            'circulation' => 'mdi mdi-arrow-decision',
            'membership' => 'mdi mdi-account-multiple',
            'master_file' => 'mdi mdi-database-edit',
            'stock_take' => 'mdi mdi-text-box-search',
            'system' => 'mdi mdi-cog',
            'reporting' => 'mdi mdi-file-table',
            'serial_control' => 'mdi mdi-qrcode',
            '*' => 'mdi mdi-toy-brick'
        ];

        $List = '<li><a href="'. AWB .'index.php"  class="d-block w-full"><i class="mdi mdi-view-dashboard"></i> ' . __('Home') . '</a></li>';
        foreach ($_SESSION['priv'] as $Module => $Priv) {
            $ModuleTranslate = __(ucwords(str_replace('_', ' ', $Module)));
            if ($Priv['r'] && $Priv['w']) $List .= '<li><a href="'. AWB .'index.php?module=' . $Module . '"  class="d-block w-full"><i class="' . ($icon[$Module]??$icon['*']) . '"></i> ' . $ModuleTranslate . '</a></li>';
        }
        return $List;
    }

    public static function render()
    {
        global $sysconf;
        $List = self::moduleList();
        $Logo = Logo::render(['class' => 'zein-slims-logo fill-current text-dark']);
        $LibraryName = $sysconf['library_name'];
        $HTML = <<<HTML
            <div class="sidepan flex">
                <div class="h-screen">
                    <div class="w-100 inst-logo d-flex justify-content-star">
                        <div class="w-25 mr-2">
                            {$Logo}
                        </div>
                        <div class="w-50">
                            <h6 class="mt-4 text-uppercase">{$LibraryName}</h5>
                        </div>
                    </div>
                    <ul class="overflow-auto zein-side-nav">
                        {$List}
                    </ul>
                </div>
            </div>
        HTML;

        return $HTML;
    }
}