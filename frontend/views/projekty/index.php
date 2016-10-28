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
//echo '<pre>'. print_r($aDimensions, TRUE);
$this->title = 'Lista projektów';
$this->params['breadcrumbs'][] = $this->title;
$iSetMinSize = $aDimensions['iOneMinSize'];
$iSetMaxSize = $aDimensions['iOneMaxSize'];
?>

<div class="full_site">
    <div class="top_menu filter_menu">

    <?php
    
    echo Html::beginForm(['/projekty'], 'POST', ['id'=>'prj_set_filters', 'name'=>'prj_set_filers', 'class'=>'prj_set_filers']);
    foreach ($aFilters as $aData) {
        echo '<div class="prj_filter_row">';
        echo '<div class="prj_filter_question_row">';
        echo $aData['question']->name.'<br>';
        echo '</div>';
        echo '<div class="prj_filter_ansver_row">';
        echo Html::dropDownList($aData['question']->id, $aChooseFilters, ArrayHelper::map($aData['answer'], 'id', 'name'), ['prompt' => ' -- Wybierz --', 'class'=>'prj_select']);
        echo '<span class="remove-filter" rel="'.$aData['question']->id.'">Usuń filtr</span>';
        if ($aData['question']->id == 7 )
        {

        echo '<br>Wielkość domu w m2: ';
        echo \yii2mod\slider\IonSlider::widget([
            'name' => 'bar_size',
            'type' => \yii2mod\slider\IonSlider::TYPE_DOUBLE,
                'pluginOptions' => [
                'min' => $aDimensions['iAllMinSize'],
                'max' => $aDimensions['iAllMaxSize'],
                'from' => $iSetMinSize,
                'to' => $iSetMaxSize,
                'step' => 1,
                'hide_min_max' => false,
                'hide_from_to' => false,
                'onFinish' => new \yii\web\JsExpression('
                function(data) {
                $("#prj_set_filters").submit();
                }'
                    ),
                'onChange' => new \yii\web\JsExpression('
                function(data) {
                    $.ajax({
                        url: "projekty/bar-change"
                    }); 
                    
                    }'
                    )
                ]
            ]);
    }
    if ($aData['question']->id == 3 )
    {
        echo '<br>Wielkość działki: ';
        echo Html::input('text', 'SizeX', $aDimensions['iMaxX'], ['title'=>'Szerokość', 'id'=>'prj_sizex'] ) .' x ';
        echo Html::input('text', 'SizeY', $aDimensions['iMaxY'], ['title'=>'Głębokość', 'id'=>'prj_sizey']) .' m ';
    }
        echo '</div>';
        echo '</div>';
    }
    ?>
    <?= Html::endForm() ?>
    <?= Html::tag('div', 'resetuj filtry', ['class' => 'reset_all_filters']) ?>

    </div>
    <div class="another prj-items">
            <?= $this->render('products', ['dataProvider' => $dataProvider, 'sort'=>$sort]) ?>

    </div>
</div>