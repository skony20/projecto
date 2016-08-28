<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\BaseHtml;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsFilters */
/* @var $form yii\widgets\ActiveForm */

?>


<div class="products-filters-form">


    <?= Html::beginForm(['products-filters/create?id='.$_GET['id'].''], 'post'); ?>
    <?php
    $a=0;
     foreach ($aData as $_aData)
        {

            echo Html::radioList($a, '', ArrayHelper::map($_aData['answer'], 'id', 'name'),['required'=>true, 'label'=>false]);
            $a++;

        }
    ?>

    <div class="form-group">
        <?= Html::submitButton('POST', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php Html::endForm(); ?>

</div>
