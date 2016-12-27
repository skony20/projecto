<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Dostawa i płatność';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Oferujemy kilka form płatności. Wybierz odpowiednią dla swoich potrzeb.</p>
    <div class="col-md-2"><?= Html::img(Yii::$app->request->BaseUrl.'/img/pauu.png') ?></div>
    <div class="col-md-10">Szybkie i bezpieczne platności on-line. </div>
    <div class="col-md-2"></div>
    <div class="col-md-10">Tradycyjny przelew.</div>
    <p>Wysyłka</p>
    <div class="col-md-2"></div>
    <div class="col-md-10">Wszystkie wysyłki realizowane są na nasz koszt. Czas dostarczenia projektu to ok 48 godzin. <br><br>Czas wysyłki projekty uależniony jest od naszych partnerów zazwyczaj jest to do 72 godzin od daty zakupu.</div>
    
</div>
