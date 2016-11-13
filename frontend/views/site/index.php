<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Projekty';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="products-index">

<?php
Pjax::begin();
echo Html::beginForm(['/'], 'POST', ['data-pjax' => '', 'class' => 'form-inline', 'id'=>'set_filters', 'name'=>'set_filers']);
$iSetMinSize = $aDimensions['iOneMinSize'];
$iSetMaxSize = $aDimensions['iOneMaxSize'];
//echo '<br>Dimensions: '. print_r($aFiltersData, true);
//echo '<pre>'.print_r([$iSetMinSize,$iSetMaxSize ], true).'</pre>';

foreach ($aFilters as $aData) {

    echo '<div class="filter_question_row">';
    echo $aData['question']->name.'<br>';
    echo '</div>';
    echo '<div class="filter_ansver_row">';
    echo Html::radioList($aData['question']->id, $aFiltersData ,ArrayHelper::map($aData['answer'], 'id', 'name'), ['class'=>'answer']);
    echo Html::tag('Resetuj','Resetuj',['class'=>'reset_filter', 'rel'=>$aData['question']->id]);
    if ($aData['question']->id == 7 )
    {

       echo '<br>Wielkość domu w m2: ';
        echo \yii2mod\slider\IonSlider::widget([
            'name' => 'house_size',
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
                    $("#set_filters").submit();
                    
                    }'
                    ),
                'onChange' => new \yii\web\JsExpression('
                function(data) {
                    $.ajax({
                        url: "site/bar-change"
                    }); 
                    
                    }'
                    )
                ]
            ]);
    }
    if ($aData['question']->id == 3 )
    {
        echo '<br>Wielkość działki: ';
        echo Html::input('text', 'SizeX', $aDimensions['iMaxX'], ['title'=>'Szerokość']) .' x ';
        echo Html::input('text', 'SizeY', $aDimensions['iMaxY'], ['title'=>'Głębokość']) .' metrów ';
    }
   

    echo '</div>';
}
?>
<?= Html::SubmitButton('Pokaż projekty', ['class' => 'project_ready', 'name' => 'project_ready']) ?>
<?= Html::endForm() ?>

    <div class="all_project">Projekty spełniające kryteria: <?= $sProjectCount ?><br><br></div>

<?php
    Pjax::end();

?>

