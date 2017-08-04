<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\BlogAuthor;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use pendalf89\filemanager\widgets\FileInput;
use pendalf89\filemanager\widgets\TinyMCE;
use tolik505\tagEditor\TagEditor;
use common\models\BlogCategory;
use common\models\BlogPostToCategory;
use common\models\BlogTag;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPost */
/* @var $form yii\widgets\ActiveForm */
$oPostTag = new BlogTag();
?>

<div class="blog-post-form">

    <?php $form = ActiveForm::begin(['id'=>'post']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'title_clean')->textInput(['maxlength' => true]) ?>
    <?= $form->field($oBlogPostToCategory, 'category_id')->dropDownList(ArrayHelper::map(BlogCategory::find()->all(), 'id', 'name'), ['prompt' => '-=Wybierz kategorię=-'])?>
    <?= $form->field($oPostTag, 'tag')->widget(TagEditor::className(), [
        'tagEditorOptions' => [
            'placeholder' => 'Wpisuj tagi rozdzielając je tabulacją',
            'initialTags' =>$oBlogTag,
            'autocomplete' => [
                'source' => 'tags/'
            ],
        ]
    ]) ?>
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
    'buttonName' => 'Dodaj zdjęcie',
    'buttonOptions' => ['class' => 'btn btn-default'],
    'options' => ['class' => 'form-control'],
    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
    'thumb' => 'original',
    'imageContainer' => '.img',
    'pasteData' => FileInput::DATA_URL,
])?>
    <br>
    <?= $form->field($model, 'featured', ['options' => ['class' => 'inline-row']])->checkbox(['class'=>'inline']) ?>

    <?= $form->field($model, 'enabled', ['options' => ['class' => 'inline-row']])->checkbox(['class'=>'inline']) ?>

    <?= $form->field($model, 'comments_enabled', ['options' => ['class' => 'inline-row']])->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Zmień', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
