<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\color\ColorInput;
/* @var $this yii\web\View */
/* @var $model app\models\OrdersStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-status-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal',]);    ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'background_color')->widget(ColorInput::classname(), [
    'options' => ['placeholder' => 'Wybierz kolor ...'],
    ]); ?>

    <?= $form->field($model, 'send_to_client')->checkbox() ?>

    <div class="form-group text-right col-md-10">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Zmień', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
