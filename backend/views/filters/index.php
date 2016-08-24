<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\FiltersGroup;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FiltersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Odpowiedzi');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filters-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Dodaj odpowiedź'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'label'=>'Aktywny',
                'value' =>  function($data)
                    {
                        return ($data->is_active = 1 ? 'Tak': 'Nie' );
                    },
                'contentOptions' => ['class' => '50p'],
                'headerOptions' => ['class' => '50p'],
                'filter' => Html::activeDropDownList($searchModel, 'is_active', ['1'=>'Tak', '0'=>'Nie'],['class'=>'form-control','prompt' => 'Wybierz']),
            ],
            'name',
            //'language_id',
            
            //'description',
            [
                'label'=>'Pytanie',
                'value' =>  function($data)
                    {
                        return FiltersGroup::getFilterGroupName($data->filters_group_id);
                    },
                'filter' => Html::activeDropDownList($searchModel, 'filters_group_id', ArrayHelper::map(FiltersGroup::find()->orderBy('sort_order')->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Wybierz pytanie']),
            ],
             'sort_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
