<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
  

<div class="acoount-side-bar">
    <div class="account-title">Moje konto</div>
    <ul class="acount-menu">
        
        <li><?= Html::a('Zmiana hasła', Yii::$app->request->BaseUrl.'/user/change-password') ?></li>
        <li><?= Html::a('Dane adresowe', Yii::$app->request->BaseUrl.'/user/adress-data') ?></li>
        <li><?= Html::a('Moje zamówienia', Yii::$app->request->BaseUrl.'/user/orders') ?></li>
        <li><?= Html::a('Ulubione projekty', Yii::$app->request->BaseUrl.'/user/favorites') ?></li>
        <li><?= Html::beginForm([Yii::$app->request->BaseUrl.'/site/logout'], 'post')?>
            <?= Html::submitButton('Wyloguj mnie',['class' => 'btn btn-link account-logout'])?>
            <?= Html::endForm() ?></li>
    </ul>
   
</div>
