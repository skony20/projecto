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
            <div class="p50p delivery">
            Dane do wysłki:
                <?= $form->field($model, 'delivery_name')->textInput() ?>
            </div>
            <div class="p50p invoice">
            Dane do faktury:
                <?= $form->field($model, 'invoice_name')->textInput() ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Rejestracja', ['class' => '', 'name' => 'signup-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
