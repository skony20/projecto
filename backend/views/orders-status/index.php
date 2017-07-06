<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Statusy zamówienia';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-status-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Dodaj status zamówienia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            [
                'label'=>'Kolor',
                'value' =>  function($data)
                    {
                        return '<div class="order-status-background" style="background-color:'.$data->background_color.';">'.$data->background_color.'</div>';
                    },
                'format'=>'raw'
            ],
            [
                'label'=>'Wysyłany do klienta',
                'value' =>  function($data)
                    {
                        return ($data->send_to_client == 1 ? 'Tak': 'Nie' );
                    },
            ],

            [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'color:#337ab7'],
            'template' => '{view} {update} {delete}',
            'buttons' => [
              'update' => function ($url, $model) {
                    return '<span class="glyphicon glyphicon-pencil showModalButton like-a" value="'.$url.'" title="Zmień status"></span>';
                    }
                ],
            ],
        ],
    ]); ?>
</div>
