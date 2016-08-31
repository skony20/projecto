<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductsAttributes */
$model->products_id = $_GET['id'];
$this->title = Yii::t('app', 'Dodaj Dane techniczne');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="products-attributes-create">


    <?= $this->render('_form', [
        'model' => $model,
        'aAttributes' => $aAttributes,
        'aProductsAttributes' => $aProductsAttributes,
    ]) ?>

</div>
