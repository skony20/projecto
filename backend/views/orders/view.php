<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'is_deleted',
            'customers_id',
            'languages_id',
            'order_date',
            'order_code',
            'orders_status_id',
            'customer_ip',
            'customer_phone',
            'customer_email:email',
            'delivery_name',
            'delivery_lastname',
            'delivery_firm_name',
            'delivery_street_local',
            'delivery_zip',
            'delivery_city',
            'delivery_country',
            'delivery_nip',
            'invoice_name',
            'invoice_lastname',
            'invoice_firm_name',
            'invoice_street_local',
            'invoice_zip',
            'invoice_city',
            'invoice_country',
            'invoice_nip',
            'comments:ntext',
            'shippings_payments_id',
            'shippings_couriers_id',
            'shippings_netto',
            'shippings_vat',
            'shippings_vat_rate',
            'shippings_brutto',
            'shippings_name:ntext',
            'value_netto',
            'value_vat',
            'value_brutto',
            'realization_date',
            'paid_date',
            'send_date',
            'creation_date:datetime',
            'modification_date',
            'is_giodo',
        ],
    ]) ?>

</div>
