<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Dane konta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Witaj <?=Yii::$app->user->identity->delivery_name?></p>

    <div class="row">
        <?php $form = ActiveForm::begin(['action'=>'?action=changepassword' ,'id' => 'change-password']); ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= Html::submitButton('Rejestracja', ['class' => '', 'name' => 'signup-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    
</div>
