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
foreach ($aFilters as $aData) {

    echo '<div class="filter_question_row">';
    echo $aData['question']->name.'<br>';
    echo '</div>';
    echo '<div class="filter_ansver_row">';
    echo Html::radioList($aData['question']->id, $aFiltersData ,ArrayHelper::map($aData['answer'], 'id', 'name'), ['class'=>'answer']);
    echo Html::tag('Resetuj','Resetuj',['class'=>'reset_filter', 'rel'=>$aData['question']->id]);
    echo '</div>';
}
?>
<?= Html::SubmitButton('Pokaż projekty', ['class' => 'project_ready', 'name' => 'project_ready']) ?>
<?= Html::endForm() ?>

    <div class="all_project">Projekty spełniające kryteria: <?= $sProjectCount ?><br><br></div>

<?php
    Pjax::end();

?>

