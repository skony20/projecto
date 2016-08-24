<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'producers_id') ?>

    <?php // echo $form->field($model, 'pkwiu') ?>

    <?php // echo $form->field($model, 'vats_id') ?>

    <?php // echo $form->field($model, 'price_brutto_source') ?>

    <?php // echo $form->field($model, 'price_brutto') ?>

    <?php // echo $form->field($model, 'stock') ?>

    <?php // echo $form->field($model, 'rating_value') ?>

    <?php // echo $form->field($model, 'rating_votes') ?>

    <?php // echo $form->field($model, 'creation_date') ?>

    <?php // echo $form->field($model, 'modification_date') ?>

    <?php  echo $form->field($model, 'symbol') ?>

    <?php // echo $form->field($model, 'ean') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'is_archive') ?>

    <?php // echo $form->field($model, 'sell_items') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Szukaj'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
