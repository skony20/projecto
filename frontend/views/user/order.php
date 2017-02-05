<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Zamówienie';
$this->params['breadcrumbs'][] = ['label' => 'Moje konto', 'url' => ['/user/account']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-row-order">
    <div class="account-title">Zamówienie numer: <?= $aOrder->id ?> - <i><?= $aOrder->ordersStatus->name?></i></div>
    <div class="green-border"></div>
        <div class="user-row-order-content col-md-12">
            <div class="m18b">Zamówione produkty:</div>
                
                <?php 
                foreach ($aOrder->ordersPositions as $aProduct)
                {
                //echo '<pre>' .  print_r($aProduct->productsDescriptions, TRUE); die(); 
                ?>
                    <div class="order-products">
                        <div class="inline-block order-product"><?= $aProduct->quantity ?> x  </div>
                        <div class="inline-block order-product"><?= Html::a($aProduct->name, Yii::$app->request->BaseUrl.'/projekt/'.$aProduct->productsDescriptions->nicename_link.'.html')  ?></div>
                        <div class="inline-block order-product"> <?= Yii::$app->formatter->asCurrency($aProduct->quantity * $aProduct->price_brutto, ' zł') ?></div>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
       if ($aOrder->comments != '')
       {
       ?>
        <div class="user-row-order-content col-md-12">
            <div class="m18b">Uwagi do zamówienia:</div>
            <div class="user-order-comments">
                <?= $aOrder->comments ?>
            </div>
        </div>
       <?php
       }
       ?>
    <div class="col-md-6 user-order-adress">
        <div class="m18b">Zamówienie zostanie dostaczona na adres:</div>
        <div class="user-order-delivery">
            <?= $aOrder->delivery_name .' ' .$aOrder->delivery_lastname . ' ' . $aOrder->delivery_firm_name ?><br>
            <?= $aOrder->delivery_street_local ?><br>
            <?= $aOrder->delivery_zip .' ' .$aOrder->delivery_city ?><br>
            <?= $aOrder->customer_phone ?>
        </div>
    </div>
   
    <div class="col-md-6">
        <?php
        if ($aOrder->is_invoice == 1)
        {
        ?>
        <div class="m18b">Dane do faktury:</div>
        <div class="user-order-delivery">
            <?= $aOrder->invoice_nip ?><br>
            <?= $aOrder->invoice_firm_name ?><br>
            <?= $aOrder->invoice_name . ' ' . $aOrder->invoice_lastname ?><br>
            <?= $aOrder->invoice_street_local ?><br>
            <?= $aOrder->invoice_zip .' ' .$aOrder->invoice_city ?><br>
            <?= $aOrder->customer_phone ?>
        </div>
        <?php
        }
        ?>
        
    </div>
    
</div>