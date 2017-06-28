<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ImageType;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsImages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-images-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'products_id')->textInput() ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'image_type_id')->dropDownList(ArrayHelper::map(ImageType::find()->all(), 'id', 'name'), ['prompt' => '-=Rodzaj zdjęcia=-'])?>
    <?= $form->field($model, 'storey_type')->dropDownList(['0'=>'Piwnica', '1'=>'Parter' ,'2'=>'Pietro lub poddasze', '3'=>'Strych', '4'=>'Antresola', '5'=>'Przekrój'], ['prompt' => '-=Pietro=-'])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Zmień', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
