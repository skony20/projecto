<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\FaqGroup;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Faq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faq-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'answer')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'faq_group_id',['labelOptions' => ['class'=>'col-sm-2']])->dropDownList(ArrayHelper::map(FaqGroup::find()->all(), 'id', 'name'), ['prompt' => '-=Wybierz grupę=-'])->label(false)?>
    <?= $form->field($model, 'sort_order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Zmień', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
