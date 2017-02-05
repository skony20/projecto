<?php


use yii\helpers\Html;

$this->title = 'Ulubione projekty';
$this->params['breadcrumbs'][] = ['label' => 'Moje konto', 'url' => ['/user/account']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <div class="account-title">Ulubione projekty</div>
    <div class="green-border"></div>
    <div class="favorites-items">
            <?= $this->render('products', ['dataProvider' => $dataProvider, 'sort'=>$sort]) ?>

    </div>
    
</div>
