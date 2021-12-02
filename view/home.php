<?php

use Zein\Ui\Html\Element;
use Zein\Ui\App\SLiMS\Admin\{Sidepan};

defined('INDEX_AUTH') or die('No direct access!');

// Container
echo Element::create('nav', ['class' => 'zein-nav'], Sidepan::render());

?>
