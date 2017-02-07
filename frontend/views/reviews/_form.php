<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\ActiveForm;
?>

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>



        <?= $form->field($model, 'author')->input('text',['value'=>$aUser['name']]) ?>
        <?= $form->field($model, 'email')->input('text',['value'=>$aUser['email']]) ?>
        <?= $form->field($model, 'content')->textarea(['rows' => '6', 'placeholder'=>'Wyraź swoją opinię']) ?>
    
        <div class="form-group text-center">
            <?= Html::submitButton('Dodaj opinię', ['class' => 'btn btn-primary blue-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>