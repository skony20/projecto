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
        echo '<span class="remove-filter" rel="'.$aData['question']->id.'">Usuń filtr</span>';
        if ($aData['question']->id == 3 )
        {

           echo '<br>Szerokość: ';
            echo \yii2mod\slider\IonSlider::widget([
                'name' => 'slider_x',
                'type' => \yii2mod\slider\IonSlider::TYPE_DOUBLE,
                    'pluginOptions' => [
                    'min' => $aDimensions['iAllMinX'],
                    'max' => $aDimensions['iAllMaxX'],
                    'from' => $aDimensions['iOneMinX'],
                    'to' => $aDimensions['iOneMaxX'],
                    'step' => 1,
                    'hide_min_max' => false,
                    'hide_from_to' => false,
                    'onChange' => new \yii\web\JsExpression('
                    function(data) {
                         $("#set_filters").submit();
                    }'
                        )
                    ]
                ]);
            echo '<br>Głębokość: ' ;
            echo \yii2mod\slider\IonSlider::widget([
                'name' => 'slider_y',
                'type' => \yii2mod\slider\IonSlider::TYPE_DOUBLE,
                    'pluginOptions' => [
                    'min' => $aDimensions['iAllMinY'],
                    'max' => $aDimensions['iAllMaxY'],
                    'from' => $aDimensions['iOneMinY'],
                    'to' => $aDimensions['iOneMaxY'],
                    'step' => 1,
                    'hide_min_max' => false,
                    'hide_from_to' => false,
                    'onChange' => new \yii\web\JsExpression('
                    function(data) {
                         $("#set_filters").submit();
                    }'
                        )
                    ]
                ]);
        }
        echo '</div>';
        echo '</div>';
    }
    ?>
    <?= Html::endForm() ?>
    <?= Html::tag('div', 'resetuj filtry', ['class' => 'reset_all_filters']) ?>

    </div>
    <div class="another prj-items">


            <?= $this->render('products', ['dataProvider' => $dataProvider]) ?>

    </div>
</div>