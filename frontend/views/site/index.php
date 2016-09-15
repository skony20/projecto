<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Products;
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
//echo '<pre>rr' .print_r($aFilters, True). '</pre>'; die();
$a = 0;
foreach ($aFilters as $aData) {
    
    echo $aData['question']->name.'<br>';

    echo Html::radioList($a, '' ,ArrayHelper::map($aData['answer'], 'id', 'name'), ['class'=>'answers']);
    $a++;
}
?>
    <div class="array_content">
        
    </div>
    
<?php
//foreach ($dataProvider->models as $model) {
//    
//    echo $model->symbol.' - '.$model->id .'<br>';
//}
?>
    
