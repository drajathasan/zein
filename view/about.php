<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-21 09:13:32
 * @modify date 2021-12-21 09:13:32
 * @license GPLv3
 * @desc [description]
 */

use Zein\Ui\Components\Bs\Container;

defined('INDEX_AUTH') or die('No direct access!');

$Background = zeinUrl('images/profile-bg.jpg');
$ProfileImage = SWB . 'images/persons/person.png';
$TemplateVersion = ZEIN_VERSION;

$Container = Container::init('fluid');
// Column
$Container->row()->col([
    'content' => [
            ['class' => 'col-8 h-75 p-3 mt-3', 'slot' => <<<HTML
                <div class="rounded-lg bg-white ml-5 p-4 d-block" style="height: 75vh">
                    <h3 class="mb-3">About Zein</h3>
                    <strong class="d-block">Version : {$TemplateVersion}</strong>
                    <strong class="d-block">License : GPLv3</strong>
                    <p class="text-justify mt-3">
                        <strong>Zein</strong> merupakan template admin untuk SLiMS >= 9.4.0 yang terinspirasi dari template dashboard Argon. Apa yang anda lihat bukanlah hasil copy-paste template dengan mesin kloning seperti httrack melain kan rakitan dan dibuat dengan bantuan library CSS dari bootstrap bawaan SLiMS 9 dll, jadi ini tidak murni saya buat dari nol melainkan rakitan. Saya berharap anda dapat menikmati template ini dengan Bebas (Dikustom sesuai keinginan) dengan <strong>etika</strong> yang berlaku :).
                    </p>
                    <button class="btn btn-primary check-update"><i class="mdi mdi-checkbox-marked-circle-outline"></i> Check Update</button>
                    <button class="btn btn-secondary btn-wait d-none">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="d-inline-block" width="20" height="20" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                            <circle cx="50" cy="50" r="32" stroke-width="8" stroke="#e0e0e0" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
                                <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>
                            </circle>
                        </svg> 
                        Please wait ....
                    </button>
                </div>
            HTML],
            ['class' => 'col-4 h-75 p-3 mt-3', 'slot' => <<<HTML
                <div class="rounded-lg bg-white mr-5 d-block" style="height: 75vh">
                    <img src="{$Background}" class="profile-bg"/>
                    <img src="{$ProfileImage}" class="rounded-circle w-25 shadow-lg profile-img"/>
                    <span class="imageCopyRight"> Photo by <a href="https://unsplash.com/@mak_flex?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Mak Flex</a> on <a href="https://unsplash.com/s/photos/forest-landscape?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a></span>
                    <div class="mt-4 p-2 text-center ">
                        <h5 class="mt-5">Drajat Hasan</h5>
                        <span class="text-muted">Kang Ketik</span>
                    </div>
                    <div class="mt-1 p-2 text-center d-flex">
                        <div class="p-2 flex-fill">
                            <a href="https://api.whatsapp.com/send/?phone=628973735575" class="notAJAX" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="d-block mx-auto" viewBox="0 0 16 16">
                                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                </svg>
                                08973735575
                            </a>
                        </div>
                        <div class="p-2 flex-fill">
                            <a href="https://t.me/drajathasan" class="notAJAX" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="d-block mx-auto" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
                                </svg>
                                drajathasan
                            </a>
                        </div>
                        <div class="p-2 flex-fill">
                            <a href="https://www.youtube.com/c/MafriaTechEdu" class="notAJAX" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="d-block mx-auto" viewBox="0 0 16 16">
                                    <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                                </svg>
                                MafriaTechEdu
                            </a>
                        </div>
                    </div>
                    <div class="text-center font-weight-bold">
                        SLiMS Plugin Maker, GNU/Linux User
                    </div>
                </div>
            HTML]
    ]
]);

echo $Container->create();
?>
<script>
    $('#mainContent').attr('style', 'background-color: rgb(223 223 223)');

    if (window.navigator.onLine)
    {
        $('.profile-img').attr('src', 'https://avatars.githubusercontent.com/u/38057222');
    }

    $('.check-update').click(function(){
        $(this).addClass('d-none');
        $('.btn-wait').removeClass('d-none');
    });
</script>