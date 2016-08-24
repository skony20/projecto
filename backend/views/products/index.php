<?php
/*MariuszS*/
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Products;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Projekty');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Dodaj Projekt'), ['create'], ['class' => 'btn btn-success']) ?>
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
            //'sort_order',
            //'producers_id',
            [
                'label'=>'Dostawca',
                'value' =>  'producers.name',
                'filter' => Html::activeDropDownList($searchModel, 'producers_id', ArrayHelper::map(app\models\Producers::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Wybierz']),
            ],
            //'pkwiu',
            [
                'label'=>'Stawka VAT',
                'value' =>  'vats.name',
                'filter' => Html::activeDropDownList($searchModel, 'vats_id', ArrayHelper::map(\app\models\Vats::find()->orderBy('id DESC')->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Wybierz']),
            ],
            [
                'label'=>'Nazwa',
                'value' => function ($model)
                {
                    $sFullName = $model->productsDescriptons[0]->name . ' '. $model->productsDescriptons[0]->name_model. ' ' . $model->productsDescriptons[0]->name_subname;
                    return $sFullName;
                },
            ],
//            [
//                'label'=>'Język',
//                'value' => function ($model)
//                {
//                    return $model->languages[0]->name;
//                },
//            ],
            [   
                'label'=> 'Cena',
                'value'=> function ($model)
                {
                    $formatter = new \yii\i18n\Formatter;
                    return $formatter->asCurrency($model->price_brutto_source, 'zł');
                }   
            ],
            //'price_brutto',
            // 'stock',
            // 'rating_value',
            // 'rating_votes',
            // 'creation_date',
            // 'modification_date',
             'symbol',
            // 'ean',
            // 'image',
            // 'is_archive',
            // 'sell_items',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php

?>
