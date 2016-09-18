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
//echo '<pre>'. print_r($dataProvider, TRUE); die();
Pjax::begin();
echo Html::beginForm(['/'], 'POST', ['data-pjax' => '', 'class' => 'form-inline']);
foreach ($aFilters as $aData) {

    echo $aData['question']->name.'<br>';
    echo Html::radioList($aData['question']->id, $aFiltersData ,ArrayHelper::map($aData['answer'], 'id', 'name'), ['class'=>'answers']);
}
?>
<?= Html::submitButton('Pokaż projekty', ['class' => 'btn btn-lg btn-primary', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>
<?php
//echo '<pre>'. print_r($dataProvider->models, TRUE); die();
foreach ($dataProvider->models as $model)
{
    echo $model->symbol.' - '.$model->id .'  ';
}
Pjax::end();
?>

