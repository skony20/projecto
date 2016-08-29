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

            echo '<div class="radiolist_prdflt">';
            echo '<label class="question_label">' .$_aData['question']->name.'</label>';
            echo Html::radioList($a, $aProductsFilters ,ArrayHelper::map($_aData['answer'], 'id', 'name') ,
                    [
                        'item' => function($index, $label, $name, $checked, $value)
                        {

                                    return Html::radio($name, $checked, [
                                    'value' => $value,
                                    'label' => Html::encode($label),
                                    'required' =>true,
                                        ]) .'<br>';
                        }
                            ]);
            echo '</div>';
            $a++;
        }
    ?>

    <div class="form-group">
        <?= Html::submitButton('POST', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php Html::endForm(); ?>

</div>
