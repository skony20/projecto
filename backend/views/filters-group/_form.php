<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FiltersGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filters-group-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
        $model->is_active = ($model->isNewRecord ? 1 : $model->is_active);
        $model->language_id = 1;
    ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nicename_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort_order')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Dodaj') : Yii::t('app', 'Zmień'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
