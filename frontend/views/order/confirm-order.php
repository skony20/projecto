<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title = 'Potwierdzenie zamówienia';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-confirm">
    Dziękujemy za złożne zamówienie.<br><br>
    Twój numer zamówienia to: <span class="order-number"><?= $iOrderId ?></span><br><br>
    Status zamówienia możesz sprawdzić klikając "Moje konto" > "Zamówienia".<br><br>
    
</div>
