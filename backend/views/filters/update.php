<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Filters */

$this->title = Yii::t('app', 'Zmień {modelClass}: ', [
    'modelClass' => 'Odpowiedź',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Odpowiedź'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Zmień');
?>
<div class="filters-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
