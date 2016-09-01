<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FiltersGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pytania');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filters-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Dodaj pytanie'), ['create'], ['class' => 'btn btn-success']) ?>
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
                        return ($data->is_active == 1 ? 'Tak': 'Nie' );
                    },
                'contentOptions' => ['class' => '50p'],
                'headerOptions' => ['class' => '50p'],
                'filter' => Html::activeDropDownList($searchModel, 'is_active', ['1'=>'Tak', '0'=>'Nie'],['class'=>'form-control','prompt' => 'Wybierz']),
            ],
            'name',
            //'language_id',
            'description',
            // 'nicename_link',
             'sort_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
