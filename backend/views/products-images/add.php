
<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2017-06-23, 14:27:00
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ImageType;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsImages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-images-form-add">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'importFile')->fileInput(['style'=>'display:none'])->label('<i class="fa fa-upload fa-2x" aria-hidden="true"></i>',['class'=>'btn btn-default btn-sm center-block btn-file']) ?>

    <div class="form-group">
        <?= Html::submitButton('Dodaj', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
