<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Logowanie';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    
    <div class="col-md-6">

        <div class="m21b login-title">Logowanie</div>
        <div class="green-border"></div>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>



        <div class="form-group login-buttons">
            <?= Html::submitButton('Zaloguj się', ['class' => 'login-button', 'name' => 'login-button']) ?>
            <div class="facebook-login">
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['site/auth'],
                ]) ?>
        </div>
        </div>
        
        <?php ActiveForm::end(); ?>
        
        <div style="color:#999;margin:1em 0">
            Nie pamiętasz hasła ? Możesz je <?= Html::a('zresetować tutaj', ['site/request-password-reset']) ?>.
        </div>
    </div>
    <div class="col-md-6">
        <div class="m21b login-title">Nie masz jeszcze konta? Zarejestruj się!</div>
        <div class="green-border"></div>
        <div class="login-registry">
            <div class="m15b">Zakładając konto zyskujesz:</div>
            <ul class="registry-plus">
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Możliwość śledzenia statusu zamówienia</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Dostęp do historii zamówień</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Możliwość dodawania ulubionych projektów</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Tylko raz podajesz dane adresowe</li>
            </ul>
            <?= Html::tag('div', Html::a('Zarejestruj się', Yii::$app->request->BaseUrl.'/signup'), ['class'=>'registry-button']) ?>
        </div>
    </div>
    

    
</div>
