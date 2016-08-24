<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Producers */

$this->title = Yii::t('app', 'Zmień {modelClass}: ', [
    'modelClass' => 'Producent',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Producenci'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Zmień');
?>
<div class="producers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
