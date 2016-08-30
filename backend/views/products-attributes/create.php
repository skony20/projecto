<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductsAttributes */
$model->products_id = $_GET['id'];
$this->title = Yii::t('app', 'Dodaj Products Attributes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="products-attributes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'aAttributes' => $aAttributes,
        'aProductsAttributes' => $aProductsAttributes,
    ]) ?>

</div>
