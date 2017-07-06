<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OrdersStatus */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Status zamówienia', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-status-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Zmień', ['update', 'id' => $model->id], ['class' => 'btn btn-primary showModalButton']) ?>
        <?= Html::a('Kasuj', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Jesteś pewien że chcesz usunąć?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label'=>'Kolor',
                'value' =>  function($data)
                    {
                        return '<div class="order-status-background"  style="background-color:'.$data->background_color.';">'.$data->background_color.'</div>';
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
        ],
    ]) ?>

</div>
