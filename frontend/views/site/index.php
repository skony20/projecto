<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Projekty');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

<?php
Pjax::begin();

echo Html::beginForm(['/'], 'POST', ['data-pjax' => '', 'class' => 'form-inline', 'id'=>'set_filters', 'name'=>'set_filers']);
$iSetMinX = $aDimensions['iOneMinX'];
$iSetMaxX = $aDimensions['iOneMaxX'];
$iSetMinY = $aDimensions['iOneMinY'];
$iSetMaxY = $aDimensions['iOneMaxY'];

foreach ($aFilters as $aData) {

    echo '<div class="filter_question_row">';
    echo $aData['question']->name.'<br>';
    echo '</div>';
    echo '<div class="filter_ansver_row">';
    echo Html::radioList($aData['question']->id, $aFiltersData ,ArrayHelper::map($aData['answer'], 'id', 'name'), ['class'=>'answer']);
    echo Html::tag('Resetuj','Resetuj',['class'=>'reset_filter', 'rel'=>$aData['question']->id]);
    if ($aData['question']->id == 3 )
    {

       echo '<br>Szerokość: ';
        echo \yii2mod\slider\IonSlider::widget([
            'name' => 'slider_x',
            'type' => \yii2mod\slider\IonSlider::TYPE_DOUBLE,
                'pluginOptions' => [
                'min' => $aDimensions['iAllMinX'],
                'max' => $aDimensions['iAllMaxX'],
                'from' => $iSetMinX,
                'to' => $iSetMaxX,
                'step' => 1,
                'hide_min_max' => false,
                'hide_from_to' => false,
                'onChange' => new \yii\web\JsExpression('
                function(data) {
                $.ajax({
                    url: "site/add-to-session?id=X",
                    type: "POST",
                    data: {
                         iPostMinX : data["from"],
                         iPostMaxX : data["to"]
                    }
                });
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
                'from' => $iSetMinY,
                'to' => $iSetMaxY,
                'step' => 1,
                'hide_min_max' => false,
                'hide_from_to' => false,
                'onChange' => new \yii\web\JsExpression('
                function(data) {
                $.ajax({
                    url: "site/add-to-session?id=Y",
                    type: "POST",
                    data: {
                         iPostMinY : data["from"],
                         iPostMaxY : data["to"]
                    }
                });
                     $("#set_filters").submit();
                }'
                    )
                ]
            ]);
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

