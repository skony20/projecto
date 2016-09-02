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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Dodaj Projekt'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'layout'=>'{pager}{summary}{items}{pager}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            [
                'label'=>'',
                'format' => 'raw',
                'value'=> function($model)
                {
                    $sPatch = Yii::$app->request->getBaseUrl(true);
                    return '<img src="'.$sPatch.'/../../images/'.$model->id.'/big/'.$model->productsDescriptons->nicename_link.'_0.jpg" style="height:50px;"/>';
                },
            ],
            [
                'attribute' => 'is_active',
                'value' =>  function($data)
                    {
                        return ($data->is_active == 1 ? 'Tak': 'Nie' );
                    },
                'contentOptions' => ['class' => '50p'],
                'headerOptions' => ['class' => '50p'],
                'filter' => Html::activeDropDownList($searchModel, 'is_active', ['1'=>'Tak', '0'=>'Nie'],['class'=>'form-control','prompt' => 'Wybierz']),
            ],
            //'sort_order',
            //'producers_id',
            [
                'attribute' => 'producers_id',
                'value' =>  'producers.name',
                'filter' => Html::activeDropDownList($searchModel, 'producers_id', ArrayHelper::map(app\models\Producers::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Wybierz']),
            ],
            //'pkwiu',
//            [
//                'attribute' => 'vats_id',
//                'value' =>  'vats.name',
//                'filter' => Html::activeDropDownList($searchModel, 'vats_id', ArrayHelper::map(\app\models\Vats::find()->orderBy('id DESC')->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Wybierz']),
//            ],
            [
                'label'=>'Nazwa',
                'format' => 'raw',
                'value' => function ($model)
                {
                    $sName = (is_object($model->productsDescriptons) ? $model->productsDescriptons->name: '');
                    $sNameModel = (is_object($model->productsDescriptons) ? $model->productsDescriptons->name_model: '');
                    $sNameSubname = (is_object($model->productsDescriptons) ? $model->productsDescriptons->name_subname: '');
                    return $sName . ' <b>'. $sNameModel .'</b> ' .$sNameSubname;
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
                'attribute' => 'price_brutto_source',
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
            [
                'label' => 'Odpowiedzi',
                'format' => 'raw',
                'value' => function ($model)
                {
                    $sName = (is_object($model->productsDescriptons) ? $model->productsDescriptons->name: '');
                    $sNameModel = (is_object($model->productsDescriptons) ? $model->productsDescriptons->name_model: '');
                    $sNameSubname = (is_object($model->productsDescriptons) ? $model->productsDescriptons->name_subname: '');
                    $sFullName = 'Dodaj odpowiedzi do: '.$sName . ' '. $sNameModel .' ' .$sNameSubname;
                    $sFullNameAttr = 'Dodaj dane techniczne do: '.$sName . ' '. $sNameModel .' ' .$sNameSubname;
                    $sFiltersButton = Html::button('Dodaj odpowiedzi', ['value' => Url::to(['products-filters/create', 'id' => $model->id]), 'title' => $sFullName, 'class' => 'showModalButton btn btn-success']);
                    $sAttrButton = Html::button('Dane techniczne', ['value' => Url::to(['products-attributes/create', 'id' => $model->id]), 'title' => $sFullNameAttr, 'class' => 'showModalButton btn btn-success']);
                    return $sFiltersButton . ' <br> ' . $sAttrButton;
                }
            ],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php

?>
