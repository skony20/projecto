<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\InProject */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Co w projekcie', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="in-project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Zmień', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            [
                'attribute' => 'Pracownia',
                'value'=>$model->producers->name,
            ],
            'description:ntext',
        ],
    ]) ?>

</div>
