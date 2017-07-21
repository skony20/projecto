<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPostToCategory */

$this->title = $model->category_id;
$this->params['breadcrumbs'][] = ['label' => 'Blog Post To Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-to-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Zmień', ['update', 'category_id' => $model->category_id, 'post_id' => $model->post_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Kasuj', ['delete', 'category_id' => $model->category_id, 'post_id' => $model->post_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Jesteś pewien że chcesz usunąć?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'category_id',
            'post_id',
        ],
    ]) ?>

</div>
