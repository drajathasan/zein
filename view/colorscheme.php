<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-06 21:26:47
 * @modify date 2021-12-06 21:26:47
 * @license GPLv3
 * @desc [description]
 */

use Zein\Ui\Html\Element;
use Zein\Ui\Components\Bs\HorizontalForm;

defined('INDEX_AUTH') or die('No direct access!');

// Horizontal Form
$HorizontalForm = HorizontalForm::getInstance();
// Form Attribute
$HorizontalForm
    ->setTitle('Zein Config')
    ->setMethod('POST')
    ->setAction(AWB . 'index.php/zein/config/save')
    ->setAttribute(['id' => 'zeinTemplateConfig', 'class' => 'm-5 bg-white', 'target' => 'blindSubmit']);


/** Set field **/
// Group
$Slot = Element::create('input', ['class' => 'form-control w-25 d-inline-block mr-2', 'id' => 'colorPickerTarget', 'name' => 'color', 'value' => $color]) . 
        Element::create('button', ['class' => 'btn btn-default', 'id' => 'colorPicker'], 'Pick Color');

$HorizontalForm->Group(Element::create('strong', [], 'Color Scheme'), $Slot);

// Remove Cache
$HorizontalForm->Group(Element::create('strong', [], 'Cache'), 
            Element::create('button', ['class' => 'btn btn-default clearCache notAJAX', 'id' => 'clearCache', 'data-action' => '/zein/config/removecache'], 'Clear') . 
            Element::create('button', ['class' => 'btn btn-outline-danger mx-1', 'id' => 'resetColor', 'data-action' => '/zein/config/resetcolor'], 'Reset Color'));

// Create form
echo $HorizontalForm->setSubmitButton()->create();
?>
<script>
    if (document.querySelector('#colorPicker') !== null)
    {
        // Create a new Picker instance and set the parent element.
        // By default, the color picker is a popup which appears when you click the parent.
        var parent = document.querySelector('#colorPicker');
        var picker = new Picker(parent);
        var container = document.querySelectorAll('ul.zein-side-nav > li.active, ul.zein-side-nav > li:hover, #zein-header, .dashboard-stat, #cboxTitle');

        // You can do what you want with the chosen color using two callbacks: onChange and onDone.
        picker.onChange = function(color) {
            container.forEach(el => {
                el.setAttribute('style', `background-color : ${color.hex} !important`);
            });
            document.querySelector('#colorPickerTarget').value = color.hex;
        };

        // onDone is similar to onChange, but only called when you click 'Ok'.
    }

    $('.clearCache, #resetColor').click(async function(e) {
        e.preventDefault();

        let Action = $(this).data('action');

        try {
            let Request = await fetch(`index.php${Action}`);
            let Response = await Request.json();

            if (Response.status)
            {
                toastr.success(Response.message, 'Success');
                setTimeout(() => {
                   window.location.href = 'index.php';
                }, 2500);
            }
        } catch (error) {
            toastr.error(error, 'Error');
        }

    })
</script>