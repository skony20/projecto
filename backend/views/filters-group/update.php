<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FiltersGroup */

$this->title = Yii::t('app', 'Zmień {modelClass}: ', [
    'modelClass' => 'Pytanie',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pytania'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name' => $model->name, 'language_id' => $model->language_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Zmień');
?>
<div class="filters-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
