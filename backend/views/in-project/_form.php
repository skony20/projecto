<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Producers;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\InProject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="in-project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'producers_id')->dropDownList(ArrayHelper::map(Producers::find()->all(), 'id', 'name'), ['prompt' => '-=Pracownia=-'])?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), ['preset' => 'standard'] )?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Zmień', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
