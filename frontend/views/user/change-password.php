<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Zmiana hasła';
$this->params['breadcrumbs'][] = ['label' => 'Moje konto', 'url' => ['/user/account']];
$this->params['breadcrumbs'][] = $this->title;
//echo '<pre>'.print_r($aUser, TRUE); die();
?>
<div class="site-signup">

    <div class="account-title">Zmień hasło</div>
    <div class="green-border"></div>
    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'change-password']); ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= Html::submitButton('Zmień hasło', ['class' => 'blue-button', 'name' => 'signup-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    
   
    
</div>
