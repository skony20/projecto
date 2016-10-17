<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Rejestracja';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Wypłenij formularz by założyć konto:</p>

    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="caption">
                <div class="registry-caption">Dane do wysyłki:</div>
                <div class="registry-caption"><div class=" invoice-caption">Dane do faktury:</div></div>
            </div>
            
            <div class="p50p">
                <div class="delivery">
                    <?= $form->field($model, 'delivery_name')->textInput() ?>
                    <?= $form->field($model, 'delivery_lastname')->textInput() ?>
                    <?= $form->field($model, 'delivery_street_local')->textInput() ?>
                    <?= $form->field($model, 'delivery_zip')->textInput() ?>
                    <?= $form->field($model, 'delivery_city')->textInput() ?>
                    <?= $form->field($model, 'delivery_country')->textInput(['value'=>'Polska']) ?>
                    <?= $form->field($model, 'phone')->textInput() ?>
                    <br><br>
                    <div class="want-invoice">
                        Chcę otrzymać fakturę VAT >
                    </div>
                </div>
            </div>
            <div class="p50p">
                <div class="invoice">
                    <?= $form->field($model, 'invoice_nip')->textInput() ?>
                    <?= $form->field($model, 'invoice_name')->textInput() ?>
                    <?= $form->field($model, 'invoice_lastname')->textInput() ?>
                    <?= $form->field($model, 'invoice_firm_name')->textInput() ?>
                    <?= $form->field($model, 'invoice_street_local')->textInput() ?>
                    <?= $form->field($model, 'invoice_zip')->textInput() ?>
                    <?= $form->field($model, 'invoice_city')->textInput() ?>
                    <?= $form->field($model, 'invoice_country')->textInput(['value'=>'Polska']) ?>
                </div>
                </div>
            <div class="form-group">
                <?= Html::submitButton('Rejestracja', ['class' => '', 'name' => 'signup-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
