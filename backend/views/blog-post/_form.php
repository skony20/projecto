<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
use common\models\BlogAuthor;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use pendalf89\filemanager\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPost */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="blog-post-form">

    <?php $form = ActiveForm::begin(['id'=>'post']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'title_clean')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'article')->widget(CKEditor::className(), [
        'preset' => 'standard'
    ]) ?>

    <?=  $form->field($model, 'banner_image')->widget(FileInput::className(), [
    'buttonTag' => 'button',
    'buttonName' => 'Browse',
    'buttonOptions' => ['class' => 'btn btn-default'],
    'options' => ['class' => 'form-control'],
    // Widget template
    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
    // Optional, if set, only this image can be selected by user
    'thumb' => 'original',
    // Optional, if set, in container will be inserted selected image
    'imageContainer' => '.img',
    // Default to FileInput::DATA_URL. This data will be inserted in input field
    'pasteData' => FileInput::DATA_URL,
    // JavaScript function, which will be called before insert file data to input.
    // Argument data contains file data.
    // data example: [alt: "Ведьма с кошкой", description: "123", url: "/uploads/2014/12/vedma-100x100.jpeg", id: "45"]
    'callbackBeforeInsert' => 'function(e, data) {
        console.log( data );
    }',
])?>
    <?= $form->field($model, 'featured', ['options' => ['class' => 'inline-row']])->checkbox(['class'=>'inline']) ?>

    <?= $form->field($model, 'enabled', ['options' => ['class' => 'inline-row']])->checkbox(['class'=>'inline']) ?>

    <?= $form->field($model, 'comments_enabled', ['options' => ['class' => 'inline-row']])->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Zmień', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
