<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FiltersGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pytania i odpowiedzi');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filters-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);
    $model = new app\models\Filters;
        foreach ($aData as $_aData)
        {
            echo '<label>'. $_aData['question']->name .'</label><br>';
            echo $form->field($model, 'name')->radioList(ArrayHelper::map($_aData['answer'], 'id', 'name'));

        }
   echo '<pre>33' .  print_r($aData, TRUE) .'</pre>' ;
    ?>


