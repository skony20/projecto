<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Kontakt';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1 class="m21b"><?= Html::encode($this->title) ?></h1>
    <div class="green-border"></div>

    <p>
        Jeśli masz jakieś pytanie, problemy lub chcesz otrzymać więcej informacji wypełnij poniższy formualarz
    </p>

    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['class' => 'form-inline']]) ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('<span class="red">*</span> Imię') ?>

                <?= $form->field($model, 'email')->label('<span class="red">*</span> Adres e-mail') ?>

                <?= $form->field($model, 'subject')->label('<span class="red">*</span> Temat') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6])->label('<span class="red">*</span> Treść wiadomości') ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
