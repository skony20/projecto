<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FiltersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filters-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'language_id') ?>

    <?= $form->field($model, 'is_active') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'filters_group_id') ?>

    <?php // echo $form->field($model, 'nicename_link') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Szukaj'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Resetuj'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
