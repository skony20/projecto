<?php

use yii\helpers\Html;
use app\models\ProductsDescripton;


/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = Yii::t('app', 'Dodaj Projekt');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projekty'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$oPD = new ProductsDescripton();
?>
<div class="products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'oPD'=>$oPD,
    ]) ?>

</div>
