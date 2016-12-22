<?php
use yii\helpers\Html;
$sSearch = (isset($_GET['szukaj']) ? $_GET['szukaj']: '');
?>
<div class="wrap search-bar-wrap">
    <div class="container search-bar-container">
        <div class="col-md-2 hidden-xs  hidden-sm text-right">Szukaj projektu</div>
        <div class="col-md-10  col-xs-12 col-sm-12">
            <div class="search-from-index">
            <?php
            echo Html::beginForm();
            echo Html::input('text', 'szukaj', $sSearch, ['class'=>'search-input', 'placeholder'=>'Jakiego projektu szukasz ?']);
            echo Html::Button('<i class="fa fa-search fa-lg" aria-hidden="true"></i>',['class'=>'search-submit']);
            ?>
            <?= Html::endForm() ?>
        </div>
        </div>
    </div>
</div>