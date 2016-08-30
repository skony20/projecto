<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductsFilters */
$model->products_id = $_GET['id'];
$this->title = Yii::t('app', 'Dodaj filtry ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products Filters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="products-filters-create">


    <?= $this->render('_form', [
        'model' => $model,
        'aData' => $aData,
        'aProductsFilters'=> $aProductsFilters,
    ]) ?>

</div>
