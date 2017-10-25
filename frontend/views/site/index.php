<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Oferty pracowni projektowych - nowoczesne i tanie projekty domów';
?>
<?php
$a=1;
Pjax::begin();
echo Html::beginForm(['/'], 'POST', ['data-pjax' => '', 'class' => 'form-horizontal', 'id'=>'set_filters', 'name'=>'set_filers']);
$iSetMinSize = $aDimensions['iOneMinSize'];
$iSetMaxSize = $aDimensions['iOneMaxSize'];
$cookies = Yii::$app->request->cookies;
$accordion = $cookies->getValue('accordion');
?>


<div class="loader">
    <div class="loader-gif"><img src="<?=Yii::$app->request->BaseUrl?>/img/load.svg"></div>
</div>
<div class="products-index">
    <div class="all_project col-md-10">Projekty spełniające kryteria: <span class="projects-counts"><?= $sProjectCount ?></span></div>
<div class="panel-group" id="accordion">
<?php
foreach ($aFilters as $aData) 
    {

?>

    
      <div class="panel panel-default all-question col-md-10">
        <div class="panel-heading">
          <h4 class="panel-title filter_question_row" rel="<?=$a?>">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$a?>">
            <?= $aData['question']->name ?></a><br>
              
                
          </h4>
        </div>
        <div id="collapse<?=$a?>" class="panel-collapse collapse filter_ansver_row <?php echo  ($accordion == $a ? 'in' : '') ?>" rel="<?=$a?>">
            <div class="panel-body">
                <?php
                    echo Html::radioList($aData['question']->id, $aFiltersData ,ArrayHelper::map($aData['answer'], 'id', 'name'), [
                                    'item' => function($index, $label, $name, $checked, $value) {
                                        $return = '<div class="radio radio-primary">';
                                        $return .= '<input type="radio" name="'.$name .'" value="' . $value . '" id="radio'.$value.'"'.($checked ? "checked=1" : "").' >';
                                        $return .= '<label for="radio'.$value.'">' .$label.'</label>';
                                        $return .= '</div>';

                                        return $return;
                                    }
                                ]);


                    if ($aData['question']->id == 7 )
                    {

                       echo '<br>Wielkość domu w m2: <br><br>';
                       echo 'Min: '.Html::input('text', '', $iSetMinSize, ['title'=>'Wielkość minimalna', 'class'=>'HouseMin']);
                       echo ' Max: '.Html::input('text', '', $iSetMaxSize, ['title'=>'Wielkośc maksymalna', 'class'=>'HouseMax']);
                        echo \yii2mod\slider\IonSlider::widget([
                            'name' => 'HouseSize',
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
                                     $.ajax({
                                        url: "site/bar-change",
                                        success:
                                            function()
                                                {
                                                    $("#set_filters").submit();
                                                }
                                    }); 
                                    }'
                                    ),
                                'onUpdate' => new \yii\web\JsExpression('
                                function(data) {
                                     $.ajax({
                                        url: "site/bar-change",
                                        success:
                                            function()
                                                {
                                                    $("#set_filters").submit();
                                                }
                                    }); 
                                    }'
                                    ),
                                ]
                            ]);
                    }
                    if ($aData['question']->id == 3 )
                    {
//                        echo '<div class="area-size">';
//                        echo '<br>Wielkość działki: ';
//                        echo Html::input('text', 'SizeX', $aDimensions['iMaxX'], ['title'=>'Szerokość']) .' x ';
//                        echo Html::input('text', 'SizeY', $aDimensions['iMaxY'], ['title'=>'Głębokość']) .' m ';
//                        echo '</div>';
                    }
                ?>
                <?=Html::tag('div','Resetuj',['class'=>'reset_filter', 'rel'=>$aData['question']->id, 'title'=>'Resetuj odpowiedź'])?>
            </div>
        </div>
      </div>
    
    
    <?php
    $a++;
    }
    ?>
    </div>
    

    <div class="col-md-10 submit-projects">
    <?= Html::SubmitButton('Pokaż projekty', ['class' => 'project_ready', 'name' => 'project_ready']) ?>
    <?= Html::endForm() ?>
    </div>
    
</div>
</div>
<?php
    Pjax::end();

?>

