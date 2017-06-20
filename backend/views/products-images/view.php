<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsImages */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-images-view">

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
            'products_id',
            'name',
            'description',
            'image_type_id',
            'storey_type',
        ],
    ]) ?>

</div>
