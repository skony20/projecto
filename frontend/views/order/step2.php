<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Zamówienie krok 2 z 2';
$this->params['breadcrumbs'][] = ['label' => 'Koszyk', 'url' => ['/cart']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php


?>
 <?php $formData = ActiveForm::begin(['action'=>Yii::$app->request->baseUrl.'/order/confirm-order/']); ?> 
<div class="order-step2">
 
    <div class="row-order">
        <div class="caption">Twoje zakupy:</div>
        <div class="row-order-content">
            <table class="cart-table">
                <tr class="cart-list-row cart-list-caption m13b">
                    <td>Ilość</td>
                    <td></td>
                    <td>Projekt</td>
                    <td>Cena</td>
                    
                    <td>Razem</td>
                </tr>
                <?php 
                foreach ($aProducts as $aProduct)
                {
                ?>
                <tr class="order-list-row">
                    <td><?= $aProduct['iQty'] ?></td>
                    <td><?= Html::img(yii::getalias("@image").'/'. $aProduct['prj']->id.'/thumbs/'.$aProduct['img'][0]->name)?></td>
                    <td><?= $aProduct['desc']->name  ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($aProduct['prj']->price_brutto, ' zł')  ?><br><?= ($aProduct['prj']->price_brutto != $aProduct['prj']->price_brutto_source ?'zamiast: '.Yii::$app->formatter->asCurrency($aProduct['prj']->price_brutto_source, ' zł') :'')?></td>

                    <td><?= Yii::$app->formatter->asCurrency($aProduct['iQty'] * $aProduct['prj']->price_brutto, ' zł') ?></td>
                </tr>
                <?php
                }
                ?>
                <tr class="order-list-row cart-list-bottom">
                    <td colspan="3">Metoda płatnośći</td>
                    <td colspan="2"><?= $aPayment->name ?></td>
                </tr>
                <tr class="order-list-row cart-list-bottom">
                    <td colspan="3">Koszt dostawy</td>
                    <td colspan="2"><?= Yii::$app->formatter->asCurrency(0, ' zł')  ?></td>
                </tr>
                <tr class="order-list-row cart-list-bottom">
                    <td colspan="2">
                        <?= ($aProduct['prj']->price_brutto != $aProduct['prj']->price_brutto_source ? 'Oszczedzasz: '.Yii::$app->formatter->asCurrency($aTotal['iTotalSource'] - $aTotal['iTotal'], '') :'')?></td>
                    <td>Do zapłaty</td>
                    <td colspan="2"><?= Yii::$app->formatter->asCurrency($aTotal['iTotal'], ' zł')  ?></td>
                </tr>
            </table>
        </div>
    <div class="row-order">
        <div class="caption">Adres wysyłki:</div>
        <div class="row-order-content">
            <?= $aOrderData['Orders']['delivery_name'] . ' ' . $aOrderData['Orders']['delivery_lastname'] ?><br>
            <?= $aOrderData['Orders']['delivery_street_local'] ?><br>
            <?= $aOrderData['Orders']['delivery_zip'] . ' ' . $aOrderData['Orders']['delivery_city'] ?><br>
        </div>
    </div>
    <div class="row-order">
        <div class="caption">Uwagi do zamówienia:</div>
        <div class="row-order-content">
            <?= ($aOrderData['Orders']['comments'] != '' ? $aOrderData['Orders']['comments']: 'Brak uwag do zamówienia') ?><br>
        </div>
    </div>
    
    <div class="ord_last_row">
       
        
        <input type="checkbox" required="required" name="regulamin"> Akceptuję <?= Html::a('regulamin', Yii::$app->request->BaseUrl.'/regulamin',['target'=>'_blank']) ?> sklepu<br>
        <?= Html::submitButton('Kupuję', ['class' => 'step2-button', 'name' => 'signup-button']) ?><br>
        <span>Zamówienie wiąże się z koniecznością zapłaty</span>
    </div>
    
</div>
<?php ActiveForm::end(); ?>