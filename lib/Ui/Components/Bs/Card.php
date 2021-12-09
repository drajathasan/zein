<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-02 22:04:14
 * @modify date 2021-12-02 22:04:14
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Ui\Components\Bs;

class Card
{
    public static function deck(array $Cards)
    {
        $CardSlot = [];
        foreach ($Cards as $Card) {
            extract($Card);
            $Col = (round(12 / count($Cards)));
            $CardSlot['content'][] = ['class' => 'col-sm-12 col-md-6 col-lg-' . $Col, 'slot' => <<<HTML
                <div class="card">
                    {$icon}
                    <div class="card-body">
                        <span class="card-title zein-card-title">{$label}</span>
                        <h3 class="card-text zein-card-text font-weight-bold" data-stat="{$stat}">0,0</h3>
                        <p class="card-text"><small class="text-muted">{$sublabel}</small></p>
                    </div>
                </div>
            HTML];
        }

        return Container::init('fluid')->row('align-items-center')->col($CardSlot)->create();
    }
}