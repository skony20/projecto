<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */

$this->title = 'Zamówienie nr '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-12 order-data-row">
    <div class="order-title">Zamówienie numer <?= $model->id ?> z <?= Yii::$app->formatter->asDatetime($model->creation_date) ?> dla <?= $model->delivery_name .' '. $model->delivery_lastname ?></div>
</div>
<div class="col-md-12 order-buttons order-data-row">
    <?= Html::button('Zmień status', ['value' => Url::to(['statusform', 'id' => $model->id]), 'title' => 'Zmień status zamówienia '.$model->id, 'class' => 'showModalButton status-change']); ?>
    <?= Html::button('Zmień dane adresowe', ['value' => Url::to(['adressform', 'id' => $model->id]), 'title' => 'Zmień dane adresowe zamówienia '.$model->id, 'class' => 'showModalButton status-change']); ?>
</div>
<div class="col-md-12 order-data-row">
    <div class="col-md-6">
        <div class="order-all-title">Zamówienie</div>
        <table class="order-data">
            <tr>
                <td>Nr zamówienia:</td>
                <td><?= $model->id ?></td>                
            </tr>
            <tr>
                <td>Kod zamówienia:</td>
                <td><?= $model->order_code ?></td>                
            </tr>
            <tr>
                <td>Data zamówienia:</td>
                <td><?= Yii::$app->formatter->asDatetime($model->creation_date) ?></td>                
            </tr>
            <tr>
                <td>Opłacone: </td>
                <td><?= ($model->paid_date != 0 ? Yii::$app->formatter->asDatetime($model->paid_date) : '')  ?></td>                
            </tr>
            <tr>
                <td>Wysłane:</td>
                <td><?= ($model->send_date != 0 ? Yii::$app->formatter->asDatetime($model->send_date) : '')  ?></td>                
            </tr>
            <tr>
                <td>Wartość brutto: </td>
                <td><?= Yii::$app->formatter->asCurrency($model->value_brutto, ' zł') ?></td>                
            </tr><tr>
                <td>Faktura: </td>
                <td><?= ($model->is_invoice ? 'TAK' : 'nie') ?></td>                
            </tr>
            <tr>
                <td>Sposób płatności:</td>
                <?php $color = (isset($model->orderPayment->status) ? ($model->orderPayment->status == 'Zakończona' ? 'green' :'red') : '')?>
                <td><?= $model->payment->name ?><?=  (!empty($model->orderPayment) ? '<span style="color:'.$color.'"> ' .$model->orderPayment->status .($model->orderPayment->code ? ' - '.$model->orderPayment->code : '') .'</span>':'')?></td>                
            </tr>
            <tr>
                <td>Status zamówienia:</td>
                <td style="background-color: <?= $model->ordersStatus->background_color ?>"><?= $model->ordersStatus->name ?></td>                
            </tr>
            <tr>
                <td>Uwagi:</td>
                <td class="comments"><?= $model->comments ?></td>                
            </tr>            
        </table>        
           
    </div>
    <div class="col-md-6">
        <div class="order-user-title">Użytkowik</div>
        <table class="order-data">
            <tr>
                <td>ip:</td>
                <td><?= $model->customer_ip ?></td>                
            </tr>
            <tr>
                <td>email:</td>
                <td><?= $model->customer_email ?></td>                
            </tr>
            <tr>
                <td>telefon:</td>
                <td><?= $model->customer_phone ?></td>                
            </tr>
            <tr>
                <td>Zgona na newsletter:</td>
                <td><?= $model->is_giodo ? 'tak' : 'nie' ?></td>                
            </tr>
        </table>
    </div>
    
</div>
<div class="col-md-12 order-data-row">
    <div class="order-adress-title">Dane adresowe</div>
    <div class="col-md-6">
        <div class="order-delivery-title">Wysyłka</div>
         <table class="order-data">
            <tr>
                <td>Imię:</td>
                <td><?= $model->delivery_name ?></td>                
            </tr>
            <tr>
                <td>Nazwisko:</td>
                <td><?= $model->delivery_lastname ?></td>                
            </tr>
            <tr>
                <td>Ulica:</td>
                <td><?= $model->delivery_street_local ?></td>                
            </tr>
            <tr>
                <td>Miasto:</td>
                <td><?= $model->delivery_zip .' '. $model->delivery_city?></td>                
            </tr>
            <tr>
                <td>Telefon:</td>
                <td><?= $model->customer_phone ?></td>                
            </tr>
            <tr>
                <td>Email:</td>
                <td><?= $model->customer_email ?></td>                
            </tr>            
         </table>
    </div>
    <?php 
    if ($model->is_invoice)
    {
    ?>
    <div class="col-md-6">
        
        <div class="order-delivery-title">Faktura</div>
        <table class="order-data">
            <tr>
                <td>Nip:</td>
                <td><?= $model->invoice_nip ?></td>                
            </tr>
            <tr>
                <td>Nazwa firmy:</td>
                <td><?= $model->invoice_firm_name ?></td>                
            </tr>
            <tr>
                <td>Imię:</td>
                <td><?= $model->invoice_name ?></td>                
            </tr>
            <tr>
                <td>Nazwisko:</td>
                <td><?= $model->invoice_lastname?></td>                
            </tr>
            <tr>
                <td>Ulica:</td>
                <td><?= $model->invoice_street_local ?></td>                
            </tr>
            <tr>
                <td>Miasto:</td>
                <td><?= $model->invoice_zip .' '. $model->invoice_city ?></td>                
            </tr>            
         </table>
    </div>
    <?php
    }
    ?>
</div>
<div class="col-md-12 order-data-row">
    <div class="order-positions-title">Zamówione produkty</div>
    <table class="order-data order-positions-data">
        <tr>
            <td>Ilość</td>
            <td>Projekt</td>
            <td>Cena</td>
            <td>Wartość</td>
        </tr>
    

    <?php
    foreach ($model->ordersPositions as $aProduct)
    {
    ?>
        <tr>
            <td><?=$aProduct->quantity ?></td>
            <td><?=$aProduct->name .' '. $aProduct->name_model .' '. $aProduct->name_subname ?></td>
            <td><?= Yii::$app->formatter->asCurrency($aProduct->price_brutto , ' zł') ?></td>
            <td><?= Yii::$app->formatter->asCurrency($aProduct->value_brutto , ' zł') ?></td>
        </tr>
    <?php
    }
    ?>
    </div>
    <tr>
        <td></td>
        <td></td>
        <td>Razem</td>
        <td><?= Yii::$app->formatter->asCurrency($model->value_brutto , ' zł') ?></td>
    </tr>
</table>
</div>
