<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faq';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Dodaj Faq', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' =>  function($data)
                    {
                        return ($data->is_active == 1 ? '<div class="active_faq" rel="'.$data->id.'">ON</div>': '<div class="unactive_faq" rel="'.$data->id.'">OFF</div>' );
                    },
                'contentOptions' => ['class' => '50p'],
                'headerOptions' => ['class' => '50p'],
               
            ],
            'question:ntext',
            'answer:ntext',
            [
                'attribute' => 'faq_group_id',
                'value' =>  'groups.name',
            ],
            'sort_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
