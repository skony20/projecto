<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FaqGroup */

$this->title = 'Zmień grupę pytań: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Faq Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Zmień';
?>
<div class="faq-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
