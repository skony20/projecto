<?php
use yii\helpers\Html;
use frontend\widget\CartWidget;
?>
<div class="container">
    <div class="cart" id="cart">

        <div class="cart-name">Koszyk</div>
        <div class="cart-container">
            <div class="cart-items" id="cart-items">
                <?php $aSessionCart = Yii::$app->session->get('Cart'); ?>
                <?= CartWidget::widget(['aSessionCart' => $aSessionCart]) ?>
            </div>

        </div>
    </div>
</div>