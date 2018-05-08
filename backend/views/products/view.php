<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->productsDescriptons->name . ' '. $model->productsDescriptons->name_model . ' ' . $model->productsDescriptons->name_subname ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projekty'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Zmień'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Kasuj'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Jesteś pewien że chcesz usunąć?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::button('Dodaj odpowiedzi', ['value' => Url::to(['products-filters/create', 'id' => $model->id]), 'title' => 'Dodaj odpowiedzi do: '. $this->title, 'class' => 'showModalButton btn btn-success float-right']) ?>
        <?= Html::button('Dane techniczne', ['value' => Url::to(['products-attributes/create', 'id' => $model->id]), 'title' => 'Dodaj dane techniczne do: '. $this->title, 'class' => 'showModalButton btn btn-success float-right']) ?>
        <?= Html::a(Html::button('Pokaż w sklepie', ['title' => 'Pokaz w sklepie', 'class' => 'btn btn-info float-right']) , 'https://projekttop.pl/projekt/'.$model->productsDescriptons->nicename_link.'.html', ['target'=>'_blank']);?>
        
        
    </p>
    <?php
    $sPatch = Yii::getAlias('@image');
    
    echo '<div class="project_images">';
    
    foreach ($model->productsImages as $oProductsImages)
    {   
        echo '<div class="project_image">';
        echo '<a class="fancybox" rel="group" href="'. $sPatch.'/'.$model->id.'/big/'.$oProductsImages->name.'"><img src="'. $sPatch.'/'.$model->id.'/thumbs/'.$oProductsImages->name.'"/></a><br>';
        echo Html::button('Usuń', ['class'=>'btn btn-danger delete_image', 'rel'=>$model->id, 'rel2'=> $oProductsImages->name, 'rel3'=>$oProductsImages->id]);
        echo '<br>'.Html::button('Edytuj info', ['value' => Url::to(['products-images/update', 'id' => $oProductsImages->id]), 'title'=>'Informacje o zdjęciu','class'=>'showModalButton btn btn-info', 'rel'=>$model->id, 'rel2'=> $oProductsImages->name, 'rel3'=>$oProductsImages->id]);
        echo '</div>';
        
    }
    echo '<br>';
    echo Html::button('Dodaj zdjęcie', ['value' => Url::to(['products-images/add', 'id' => $model->id]), 'title' => 'Dodaj zdjęcie do: '. $this->title, 'class' => 'showModalButton btn float-right']);
    echo '</div>';
    ?>
    <br><br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            
            [
                'attribute' => 'is_active',
                'value'=>($model->is_active == 1 ? 'TAK' : 'NIE'),
            ],
            [
                'attribute' => 'is_archive',
                'value'=>($model->is_archive == 1 ? 'TAK' : 'NIE'),
            ],
            'symbol',
            [
                'attribute' => 'producers_id',
                'value'=>$model->producers->name,
            ],
            'ean',
            [
                'attribute'=>'vats_id',
                'value'=>$model->vats->name,
            ],
            'price_brutto_source',
            'price_brutto',
            'stock',
            'creation_date:datetime',
            'modification_date:datetime',            
            [
                'attribute' => 'is_archive',
                'value'=>($model->is_archive == 1 ? 'TAK' : 'NIE'),
            ],
            'sort_order',
        ],
    ]) ?>

</div>
