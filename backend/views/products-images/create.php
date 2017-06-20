<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductsImages */

$this->title = 'Dodaj Products Images';
$this->params['breadcrumbs'][] = ['label' => 'Products Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-images-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
