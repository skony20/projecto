<?php

use yii\helpers\Html;
use app\models\ProductsDescripton;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = Yii::t('app', 'Zmień {modelClass}: ', [
    'modelClass' => 'Projekt',
]) . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projekt'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Zmień');
?>
<div class="products-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'oPD' => $oPD,
    ]) ?>

</div>
