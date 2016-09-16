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

<?= Html::beginForm(['products-filters/create?id='.$_GET['id'].''], 'post', ['id'=>'products_filtrs']); ?>
<div class="products-filters-form">


    
    <?php

    $a=0;
    foreach ($aData as $_aData)
        {

            echo '<div class="radiolist_prdflt">';
            echo '<label class="question_label">' .$_aData['question']->name.'</label>';
            switch ($_aData['question']->id)
            {
                case 7:
                    echo Html::checkboxList($a, $aProductsFilters ,ArrayHelper::map($_aData['answer'], 'id', 'name') ,
                    [
                        'item' => function($index, $label, $name, $checked, $value)
                        {

                                    return Html::checkbox($name, $checked, [
                                    'value' => $value,
                                    'label' => Html::encode($label),
                                        ]) .'<br>';
                        }
                            ]);
                break;
                default:
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
                break;
            }
            
            echo '</div>';
            $a++;
        }
    ?>

    <div class="form-group">
            <?= Html::submitButton('POST', ['class' => 'btn btn-primary']) ?>
    </div>

</div>
    

    <?php Html::endForm(); ?>