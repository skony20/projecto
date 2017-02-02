<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Zamówienia';
$this->params['breadcrumbs'][] = ['label' => 'Moje konto', 'url' => ['/user/account']];
$this->params['breadcrumbs'][] = $this->title;
//echo '<pre>'.print_r($aUser, TRUE); die();
?>
<p class="account-title">Zamówienia</p>
<div class="site-account">
    <div class="order-row">
        <div class="order-data">Data</div>
        <div class="order-nr">Numer zamówienia</div>
        <div class="order-status">Status zamówienia</div>
        <div class="order-total">Suma zamówienia</div>
    </div>
<?php
//echo '<pre>'. print_r($aOrders->models, TRUE); die();
    
    foreach ($aOrders->models as $aOrder)
    {
    ?>
        <div class="order-row">
            <div class="order-data"><?= date('Y-m-d H:i', $aOrder->creation_date) ?></div>
            <div class="order-nr"><?= HTML::a($aOrder->id, Yii::$app->request->BaseUrl.'/user/order/'.$aOrder->id); ?></div>
            <div class="order-status"><?= $aOrder->ordersStatus->name ?></div>
            <div class="order-total"><?= $aOrder->value_brutto. ' zł' ?></div>
        </div>
    <?php
    }
?>
    

</div>
