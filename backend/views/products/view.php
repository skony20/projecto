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
    </p>
    <?php
    $sPatch = Yii::getAlias('@image');
    
    echo '<div class="project_images">';
    foreach ($model->productsImages as $oProductsImages)
    {   
        echo '<div class="project_image">';
        echo '<img src="'. $sPatch.'/'.$model->id.'/big/'.$oProductsImages->name.'" style="height:50px;"/><br>';
        echo Html::button('Usuń', ['class'=>'delete_image', 'rel'=>$model->id, 'rel2'=> $oProductsImages->name, 'rel3'=>$oProductsImages->id]);
        echo '</div>';
    }
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
            'symbol',
            [
                'attribute' => 'producers_id',
                'value'=>$model->producers->name,
            ],
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
