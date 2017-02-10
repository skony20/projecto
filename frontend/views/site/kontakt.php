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
<div class="wrap static-wrap">    
    <div class="container static-container">     
        <div class="text-center r48w static-content">Masz pytania? Zapraszamy do kontaktu</div>
    </div>
</div>
<div class="wrap">    
    <div class="container">     

        <div class="site-contact">
            <h1 class="m21b"><?= Html::encode($this->title) ?></h1>
            <div class="green-border"></div>


            <div class="row">
                <div class="col-lg-7 col-sm-12">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['class' => 'form-inline']]) ?>

                        <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('<i class="fa fa-pencil fa-lg contact-icon" aria-hidden="true"></i><span class="red">*</span> Imię') ?>

                        <?= $form->field($model, 'email')->label('<i class="fa fa-globe fa-lg contact-icon" aria-hidden="true"></i><span class="red">*</span> Adres e-mail') ?>

                        <?= $form->field($model, 'subject')->label('<i class="fa fa-tag fa-lg contact-icon" aria-hidden="true"></i><span class="red">*</span> Temat') ?>

                        <?= $form->field($model, 'body')->textarea(['rows' => 6])->label('<i class="fa fa-envelope contact-icon contact-textarea" aria-hidden="true"></i><span class="red">*</span> Treść wiadomości') ?>
                        <div class="form-group col-lg-12">
                        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                            'template' => '<div class="row"><div class="col-lg-4 col-sm-4 col-xs-4 text-right">{image}</div><div class="col-lg-4 col-sm-4 col-xs-4">{input}</div><div class="col-lg-4 col-sm-4 col-xs-4">'.Html::submitButton("Wyślij", ["class" => "contact-submit btn btn-primary", "name" => "contact-button"]).'</div></div>',
                        ])->label('<span class="red">*</span> Kod weryfikacyjny') ?>

                        
                           
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
                <div class='col-lg-5 hidden-sm'>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5868.550604765104!2d19.36769917617549!3d51.79845699257289!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471bb53e849b2b53%3A0xe6ec1d9b25fbf878!2zV2ljaSA0OCwgxYHDs2TFug!5e0!3m2!1spl!2spl!4v1486728208691" width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>

        </div>
    </div>
</div>