<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Products;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Similar;
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
                    $sPatch = Yii::getAlias('@image');
                    return '<img src="'.$sPatch.'/'.$model->id.'/thumbs/'.$model->productsDescriptons->nicename_link.'_0.jpg" style="height:50px;"/>';
                },
            ],
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' =>  function($data)
                    {
                        return ($data->is_active == 1 ? '<div class="active_prd" rel="'.$data->id.'">ON</div>': '<div class="unactive_prd" rel="'.$data->id.'">OFF</div>' );
                    },
                'contentOptions' => ['class' => '50p'],
                'headerOptions' => ['class' => '50p'],
                'filter' => Html::activeDropDownList($searchModel, 'is_active', ['1'=>'Tak', '0'=>'Nie'],['class'=>'form-control','prompt' => 'Wybierz']),
            ],
            [
                'attribute' => 'is_archive',
                'format' => 'raw',
                'value' =>  function($data)
                    {
                        return ($data->is_archive == 1 ? '<div class="archive_prd" rel="'.$data->id.'">ON</div>': '<div class="unarchive_prd" rel="'.$data->id.'">OFF</div>' );
                    },
                'contentOptions' => ['class' => '50p'],
                'headerOptions' => ['class' => '50p'],
                'filter' => Html::activeDropDownList($searchModel, 'is_archive', ['1'=>'Tak', '0'=>'Nie'],['class'=>'form-control','prompt' => 'Wybierz'])
            ],
            [
                'attribute' => 'producers_id',
                'value' =>  'producers.name',
                'filter' => Html::activeDropDownList($searchModel, 'producers_id', ArrayHelper::map(app\models\Producers::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Wybierz']),
            ],

            'prjName',


            [
                'attribute' => 'price_brutto_source',
                'value'=> function ($model)
                {
                    return $model->price_brutto_source.' zł';
                }
            ],

            [
                'attribute' => 'symbol',
                'format' => 'raw',
                'value'=> function ($model)
                {
                    
                    return '<a href="https://projekttop.pl/projekt/'.$model->productsDescriptons->nicename_link.'.html" target="_blank" >'.$model->productsDescriptons->nicename_link.'</a>';
                }
            ],


            ['class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['class' => 'action_column'],
                ],
            [
                'label' => 'Dane',
                'format' => 'raw',
                'value' => function ($model)
                {
                    $oSimilar = new Similar();
                    $sName = (is_object($model->productsDescriptons) ? $model->productsDescriptons->name: '');
                    $sNameModel = (is_object($model->productsDescriptons) ? $model->productsDescriptons->name_model: '');
                    $sNameSubname = (is_object($model->productsDescriptons) ? $model->productsDescriptons->name_subname: '');
                    $aName = explode(" ", $sName);
                    $sFullName = 'Dodaj odpowiedzi do: '.$sName . ' '. $sNameModel .' ' .$sNameSubname;
                    $sFullNameAttr = 'Dodaj dane techniczne do: '.$sName . ' '. $sNameModel .' ' .$sNameSubname;
                    $sFullNameSimilar = 'Dodaj podobne projekty do: '.$sName . ' '. $sNameModel .' ' .$sNameSubname;
                    $sFiltersButton = Html::button('Dodaj odpowiedzi', ['value' => Url::to(['products-filters/create', 'id' => $model->id]), 'title' => $sFullName, 'class' => 'showModalButton btn btn-success dane_button']);
                    $sAttrButton = Html::button('Dane techniczne', ['value' => Url::to(['products-attributes/create', 'id' => $model->id]), 'title' => $sFullNameAttr, 'class' => 'showModalButton btn btn-success dane_button']);
                    $sSimilarButton = Html::a('Dodaj podobne', Url::to(['similar/index', 'id' => $model->id, 'sName'=>$aName[0]]),['target'=>'_blank']);
                    $sSimilarButton .= ' ('. $oSimilar->countSimilar($model->id) .')';
                    return $sFiltersButton . ' <br> ' . $sAttrButton .'<br>'.$sSimilarButton;
                }
            ],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php

?>
