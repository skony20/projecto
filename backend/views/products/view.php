<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
    </p>
    <img src='../../../images/<?php echo $model->id; ?>/info/<?php echo $model->id; ?>.jpg'/>
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
