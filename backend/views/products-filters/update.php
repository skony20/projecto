<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsFilters */

$this->title = Yii::t('app', 'Zmień {modelClass}: ', [
    'modelClass' => 'Products Filters',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products Filters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Zmień');
?>
<div class="products-filters-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
