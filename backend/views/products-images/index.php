<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-images-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Dodaj Products Images', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'products_id',
            'name',
            'description',
            'image_type_id',
            // 'storey_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
