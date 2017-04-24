<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\OrdersStatus;
use app\models\PaymentsMethod;
use yii\helpers;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Zamówienia';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'layout'=>'{pager}{summary}{items}{pager}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'order_code',
                'format'=>'raw',
                'value' =>  function($data)
                    {
                        return Html::a($data->order_code, Yii::getAlias('@web').'/orders/'.$data->id);
                    }
            ],
            'order_date:datetime',
            [
                'attribute' => 'orders_status_id',
                'value' =>  'ordersStatus.name',
                'filter' => Html::activeDropDownList($searchModel, 'orders_status_id', ArrayHelper::map(OrdersStatus::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Wybierz']),
            ],
            'customer_email',
            [
                'attribute' => 'shippings_payments_id',
                'value' =>  'payment.name',
                'format'=>'raw',
                'filter' => Html::activeDropDownList($searchModel, 'shippings_payments_id', ArrayHelper::map(PaymentsMethod::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Wybierz']),
                'contentOptions' => ['class' => 'img-payment'],
            ],
            //'is_deleted',
//            [
//                'attribute' => 'customers_id',
//                'value' => function($data)
//                {
//                    return $data->delivery_name .  ' ' .$data->delivery_lastname . ' ('. $data->customer_email .')';
//                    
//                }
//            ],
            'fullName',
            //'languages_id',
            
            [
                'attribute' => 'value_brutto',
                'value' => function($data)
                {
                    return $data->value_brutto . ' zł';
                }
            ],
            
            
            // 'customer_ip',
            // 'customer_phone',
            // 'customer_email:email',
            // 'delivery_name',
            // 'delivery_lastname',
            // 'delivery_firm_name',
            // 'delivery_street_local',
            // 'delivery_zip',
            // 'delivery_city',
            // 'delivery_country',
            // 'delivery_nip',
            // 'invoice_name',
            // 'invoice_lastname',
            // 'invoice_firm_name',
            // 'invoice_street_local',
            // 'invoice_zip',
            // 'invoice_city',
            // 'invoice_country',
            // 'invoice_nip',
            // 'comments:ntext',
            // 'shippings_couriers_id',
            // 'shippings_netto',
            // 'shippings_vat',
            // 'shippings_vat_rate',
            // 'shippings_brutto',
            // 'shippings_name:ntext',
            // 'value_netto',
            // 'value_vat',
            
            // 'realization_date',
            // 'paid_date',
            // 'send_date',
            // 'creation_date',
            // 'modification_date',
            // 'is_giodo',
        ],
    ]); ?>
</div>
