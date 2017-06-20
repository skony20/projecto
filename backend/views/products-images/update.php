<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsImages */

$this->title = 'Zmień Products Images: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Zmień';
?>
<div class="products-images-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
