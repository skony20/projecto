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

            <p>
                Jeśli masz jakieś pytanie, problemy lub chcesz otrzymać więcej informacji wypełnij poniższy formualarz
            </p>

            <div class="row">
                <div class="col-lg-7 col-sm-12">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['class' => 'form-inline']]) ?>

                        <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('<i class="fa fa-pencil fa-lg contact-icon" aria-hidden="true"></i><span class="red">*</span> Imię') ?>

                        <?= $form->field($model, 'email')->label('<i class="fa fa-globe fa-lg contact-icon" aria-hidden="true"></i><span class="red">*</span> Adres e-mail') ?>

                        <?= $form->field($model, 'subject')->label('<i class="fa fa-tag fa-lg contact-icon" aria-hidden="true"></i><span class="red">*</span> Temat') ?>

                        <?= $form->field($model, 'body')->textarea(['rows' => 6])->label('<i class="fa fa-envelope contact-icon contact-textarea" aria-hidden="true"></i><span class="red">*</span> Treść wiadomości') ?>
                        <div class="form-group col-lg-12">
                        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                            'template' => '<div class="row"><div class="col-lg-4 col-sm-4">{image}</div><div class="col-lg-4 col-sm-4">{input}</div><div class="col-lg-4 col-sm-4">'.Html::submitButton("Wyślij", ["class" => "contact-submit btn btn-primary", "name" => "contact-button"]).'</div></div>',
                        ]) ?>

                        
                           
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
                <div class='col-lg-5 hidden-sm'>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d6966.78397811218!2d19.314673613240036!3d51.876837737772625!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spl!2spl!4v1482491739508" width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>

        </div>
    </div>
</div>