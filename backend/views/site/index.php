<?php

use app\models\Products;

use yii\helpers\Html;
/* @var $this yii\web\View */


$this->title = 'Najlepsze projekty domów';

?>
<div class="site-index">

    <div class="row first-row ">
        <div class="col-md-3 col-sm-6">
            <div class="info-box box-1">
                <i class="fa fa-home fa-5x" aria-hidden="true"></i>
                <span class="t42p"><?= (new Products)->Countall()?></span><br>
                <div class="t18p">aktywnych projektów domów</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 ">
            <div class="info-box box-2">
                <i class="fa fa-clock-o fa-5x" aria-hidden="true"></i>
                <span class="t42p"><?= (new Products)->Countall()?></span><br>
                <div class="t18p">oczekujących zamówień</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 ">
            <div class="info-box box-3">
                <i class="fa fa-search fa-5x" aria-hidden="true"></i>
                <span class="t42p"><?= (new Products)->Countall()?></span><br>
                <div class="t18p">wszystkich wyszukiwań</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 ">
            <div class="info-box box-4">
                <i class="fa fa-pencil-square-o fa-5x" aria-hidden="true"></i>
                <span class="t42p"><?= (new Products)->Countall()?></span><br>
                <div class="t18p">artykułów na blogu</div>
            </div>
        </div>
    </div>
</div>
