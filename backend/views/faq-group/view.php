<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FaqGroup */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Grupa pytań', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-group-view">

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
            'is_active',
            'name:ntext',
            'sort_order',
        ],
    ]) ?>

</div>
