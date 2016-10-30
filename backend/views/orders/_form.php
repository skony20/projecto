<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'is_deleted')->textInput() ?>

    <?= $form->field($model, 'customers_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'languages_id')->textInput() ?>

    <?= $form->field($model, 'order_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orders_status_id')->textInput() ?>

    <?= $form->field($model, 'customer_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_firm_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_street_local')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_zip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_nip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_firm_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_street_local')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_zip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_nip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'shippings_payments_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shippings_couriers_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shippings_vat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shippings_vat_rate')->textInput() ?>

    <?= $form->field($model, 'shippings_name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'value_brutto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'realization_date')->textInput() ?>

    <?= $form->field($model, 'paid_date')->textInput() ?>

    <?= $form->field($model, 'send_date')->textInput() ?>

    <?= $form->field($model, 'creation_date')->textInput() ?>

    <?= $form->field($model, 'modification_date')->textInput() ?>

    <?= $form->field($model, 'is_giodo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Zmień', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
