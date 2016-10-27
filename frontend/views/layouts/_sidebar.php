<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
  

<div class="acoount-side-bar">
    <div class="account-title">Moje konto</div>
    <ul class="acount-menu">
        
        <li><?= Html::a('Zmiana hasła', '/projecto/user/change-password') ?></li>
        <li><?= Html::a('Dane adresowe', '/projecto/user/adress-data') ?></li>
        <li><?= Html::a('Moje zamówienia', '/projecto/user/orders') ?></li>
        <li><?= Html::a('Ulubione projekty', '/projecto/user/favorites') ?></li>
        <li><?= Html::beginForm(['/site/logout'], 'post')?>
            <?= Html::submitButton('Wyloguj mnie',['class' => 'btn btn-link account-logout'])?>
            <?= Html::endForm() ?></li>
    </ul>
   
</div>
