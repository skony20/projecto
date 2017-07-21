<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BlogRelated */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-related-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'blog_post_id')->textInput() ?>

    <?= $form->field($model, 'blog_related_post_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Zmień', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
