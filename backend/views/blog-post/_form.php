<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\BlogAuthor;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use pendalf89\filemanager\widgets\FileInput;
use pendalf89\filemanager\widgets\TinyMCE;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPost */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="blog-post-form">

    <?php $form = ActiveForm::begin(['id'=>'post']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'title_clean')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'article')->widget(TinyMCE::className(), [
    'clientOptions' => [
           'language' => 'pl',
        'menubar' => false,
        'height' => 500,
        'image_dimensions' => false,
        'plugins' => [
            'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code contextmenu table',
        ],
        'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
    ],
]); ?>

    <?=  $form->field($model, 'banner_image')->widget(FileInput::className(), [
    'buttonTag' => 'button',
    'buttonName' => 'Dodaj',
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
])?>
    <?= $form->field($model, 'featured', ['options' => ['class' => 'inline-row']])->checkbox(['class'=>'inline']) ?>

    <?= $form->field($model, 'enabled', ['options' => ['class' => 'inline-row']])->checkbox(['class'=>'inline']) ?>

    <?= $form->field($model, 'comments_enabled', ['options' => ['class' => 'inline-row']])->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Zmień', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
