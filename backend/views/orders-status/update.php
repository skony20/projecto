<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrdersStatus */

$this->title = 'Zmień status zamówienia: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Statusy zamówienia', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Zmień';
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


