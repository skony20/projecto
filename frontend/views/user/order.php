<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Zamówienie';
$this->params['breadcrumbs'][] = ['label' => 'Moje konto', 'url' => ['/user/account']];
$this->params['breadcrumbs'][] = $this->title;
//echo '<pre>'.print_r($aOrder->ordersStatus, TRUE); die();
?>

<div class="row-order">
        <div class="caption">Zamówienie numer: <?= $aOrder->id ?> - <?= $aOrder->ordersStatus->name?></div>
        <div class="row-order-content">
            <table class="cart-table">
                <tr class="cart-list-row cart-list-caption m13b">
                    <td>Ilość</td>
                    <td>Projekt</td>
                    <td>Cena</td>
                    
                    <td>Razem</td>
                </tr>
                <?php 
                foreach ($aOrder->ordersPositions as $aProduct)
                {
                ?>
                <tr class="order-list-row">
                    <td><?= $aProduct->quantity ?></td>
                    <td><?= $aProduct->name  ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($aProduct->price_brutto, ' zł')  ?><br><?= ($aProduct->price_brutto != $aProduct->price_brutto_source ?'zamiast: '.Yii::$app->formatter->asCurrency($aProduct->price_brutto_source, ' zł') :'')?></td>

                    <td><?= Yii::$app->formatter->asCurrency($aProduct->quantity * $aProduct->price_brutto, ' zł') ?></td>
                </tr>
                <?php
                }
                ?>
                
            </table>
        </div>

    
</div>