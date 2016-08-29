<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductsFilters */

$this->title = Yii::t('app', 'Dodaj Products Filters');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products Filters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->products_id = $_GET['id'];
?>
<div class="products-filters-create">

    <h1>Dodaj filtry do: <?= Html::encode($model->products['symbol']) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'aData' => $aData,
        'aProductsFilters'=> $aProductsFilters,
    ]) ?>

</div>
