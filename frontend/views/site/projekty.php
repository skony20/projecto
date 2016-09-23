<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Products;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lista projektów');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="full_site">
    <div class="top_menu filter_menu">

    <?php
    echo Html::beginForm(['site/projekty'], 'POST', ['id'=>'prj_set_filters', 'name'=>'prj_set_filers', 'class'=>'prj_set_filers']);
    foreach ($aFilters as $aData) {
        echo '<div class="prj_filter_row">';
        echo '<div class="prj_filter_question_row">';
        echo $aData['question']->name.'<br>';
        echo '</div>';
        echo '<div class="prj_filter_ansver_row">';
        echo Html::dropDownList($aData['question']->id, $aChooseFilters, ArrayHelper::map($aData['answer'], 'id', 'name'), ['prompt' => ' -- Wybierz --', 'class'=>'prj_select']);
//        echo Html::radioList($aData['question']->id, $aChooseFilters ,ArrayHelper::map($aData['answer'], 'id', 'name') ,
//                    [
//                        'item' => function($index, $label, $name, $checked, $value)
//                        {
//
//                                    return Html::radio($name, $checked, [
//                                    'value' => $value,
//                                    'label' => Html::encode($label),
//                                    'required' =>false,
//                                    'class' =>'prj_radio'
//                                        ]).'<br>';
//                        }
//                            ]);

        echo '<span class="remove-filter" rel="'.$aData['question']->id.'">Usuń filtr</span>';
        echo '</div>';
        echo '</div>';
    }
    ?>
    <?= Html::endForm() ?>
    <?= Html::tag('div', 'resetuj filtry', ['class' => 'reset_all_filters']) ?>

    </div>
    <div class="another products-items">


            <?= $this->render('products', ['dataProvider' => $dataProvider]) ?>

    </div>
</div>