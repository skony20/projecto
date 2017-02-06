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
$this->title = 'ProjektTop.pl - wybór projektu jeszcze nigdy nie był tak prosty';
$title_bread = 'Lista projektów';
$this->params['breadcrumbs'][] = $title_bread;
$iSetMinSize = $aDimensions['iOneMinSize'];
$iSetMaxSize = $aDimensions['iOneMaxSize'];
$sSearch = (isset($sSearchC) ? $sSearchC : '');
//echo '<pre>'. print_r($_GET, TRUE). '</pre>';
//echo '<pre>'. print_r($aDimensions, TRUE). '</pre>';
$oProducts = new \app\models\Products();
$iAvalaibleProject = $oProducts->Countall();
$iAvalaibleProject = floor($iAvalaibleProject / 100)* 100;
        ?>

<div class="full_site">
    <div class="top_menu filter_menu">
        <div class="filter-menu-over text-center"><span class="o15bb">PONAD</span><br><span class="m21w"><?=$iAvalaibleProject ?> </span><span class="o15w">projektów domów</span></div>
        <div class="top-menu-find text-center"><span class="o13bw">ZNAJDŹ PROJEKT</span></div>
    <div class="top-menu-filters">
    <?php
    echo '<div class="prj_filter_row">';
    echo '<div class="prj_filter_question_row m13b">';
    echo 'nazwa planu';
    echo '</div>';
    echo '<div class="prj_filter_ansver_row o13g">';

    echo Html::beginForm();
    echo Html::input('text', 'szukaj', $sSearch, ['class'=>'search-input', 'placeholder'=>'Nazwa planu ?']);
    echo Html::Button(Html::img(Yii::$app->request->BaseUrl.'/img/search.png'),['class'=>'search-submit']);
    echo Html::endForm();
    echo '</div>';
    echo '</div>';
    echo Html::beginForm(['/projekty'], 'GET', ['id'=>'prj_set_filters', 'name'=>'prj_set_filers', 'class'=>'prj_set_filers']);
    foreach ($aFilters as $aData) {
        echo '<div class="prj_filter_row">';
        echo '<div class="prj_filter_question_row m13b">';
        echo $aData['question']->name.'<br>';
        echo '</div>';
        echo '<div class="prj_filter_ansver_row o13g">';
        echo Html::checkboxList($aData['question']->id, $aChooseFilters, ArrayHelper::map($aData['answer'], 'id', 'name'), ['class'=>'prj_select', 'rel' => $aData['question']->id]);
        //echo Html::dropDownList($aData['question']->id, $aChooseFilters, ArrayHelper::map($aData['answer'], 'id', 'name'), ['prompt' => ' -- Wybierz --', 'class'=>'prj_select', 'rel' => $aData['question']->id]);
        //echo '<span class="remove-filter" rel="'.$aData['question']->id.'">Usuń filtr</span>';
        if ($aData['question']->id == 7 )
        {

        echo '<span class="m13b text-uppercase"><br>Wielkość domu w m2: </span>';
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
                $("#prj_set_filters").submit();
                }'
                    ),
                'onChange' => new \yii\web\JsExpression('
                function(data) {
                    $.cookie("bBarChange", 1);
                    $.ajax({
                        url: "/projecto/projekty/barchange"
                    }); 
                    }'
                    )
                ]
            ]);

        }
//    if ($aData['question']->id == 3 )
//    {
//        echo '<span class="m13b text-uppercase"><br>Wielkość działki: <br></span>';
//        echo Html::input('text', 'SizeX', $aDimensions['iMaxX'], ['title'=>'Szerokość', 'id'=>'prj_sizex', 'class'=>'filter-area-size'] ) .'<span class="m13b"> x </span>';
//        echo Html::input('text', 'SizeY', $aDimensions['iMaxY'], ['title'=>'Głębokość', 'id'=>'prj_sizey', 'class'=>'filter-area-size']) .'<span class="m13b"> m </span>';
//        echo Html::hiddenInput('SizeXHidden', $aDimensions['iAllX']);
//        echo Html::hiddenInput('SizeYHidden', $aDimensions['iAllY']);
//    }
        echo '</div>';
        echo '</div>';
    }
    ?>
    <?= Html::endForm() ?>
    <?= Html::tag('div', 'resetuj filtry', ['class' => 'reset_all_filters m14b text-uppercase text-center']) ?>
    </div>
    </div>
    <div class="another prj-items">
            <?= $this->render('products', ['dataProvider' => $dataProvider, 'sort'=>$sort]) ?>

    </div>
</div>