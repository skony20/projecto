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

    
    <div class="col-md-6">
        <h1 class="m21b login-title"><?= Html::encode($this->title) ?></h1>
        <div class="green-border"></div>
        <p class="m18b">Nie masz jeszcze konta? Zarejestruj się!</p>
        <div class="row registry-row">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'agreement',['options'=>['class' => 'registry-chceckbox']])->checkbox(['checked' => false]); ?>
                <?= $form->field($model, 'newslatter',['options'=>['class' => 'registry-chceckbox']])->checkbox(['checked' => false]); ?>
                <div class="form-group text-right signup-row">
                    <?= Html::submitButton('Rejestracja', ['class' => 'registry-button', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="m21b login-title">Masz już konto ?</div>
        <div class="green-border"></div>
        <div class="signup-login">
            <?= Html::tag('div', Html::a('Zaloguj się ', Yii::$app->request->BaseUrl.'/login'), ['class'=>'registry-button']) ?>
            <div class="forgot-password"><?= Html::a('Nie pamiętam hasła', ['site/request-password-reset']) ?></div>
        </div>
        <div class="facebook-login">
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['site/auth'],
                ]) ?>
             </div>
        
    </div>
</div>
