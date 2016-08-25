<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\FiltersGroup;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Filters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filters-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $model->language_id = 1; ?>
    <?php $model->is_active = 1; ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'filters_group_id')->dropDownList(ArrayHelper::map(FiltersGroup::find()->orderBy('sort_order')->all(), 'id', 'name'), ['class'=>'form-control','prompt' => 'Wybierz pytanie'])?>
    <?= $form->field($model, 'language_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'nicename_link')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Dodaj') : Yii::t('app', 'Zmień'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
