<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsAttributes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-attributes-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php 
    //echo '<pre>' . print_r($aProductsAttributes, TRUE) . '</pre>'; die();
    foreach ($aAttributes as $_aAttributes)
    {
        echo '<div class="input_prdattr">';
        $sAttrValue = (isset($aProductsAttributes[$_aAttributes->id]) ? $aProductsAttributes[$_aAttributes->id] : '');
        echo '<label class="question_label">' .$_aAttributes->name .'</label>';
        echo Html::input('text', $_aAttributes->id, $sAttrValue, ['class'=>'form-control']) . '<br>';
        echo '</div>';
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Dodaj') : Yii::t('app', 'Zmień'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
