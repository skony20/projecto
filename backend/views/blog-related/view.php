<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BlogRelated */

$this->title = $model->blog_post_id;
$this->params['breadcrumbs'][] = ['label' => 'Blog Relateds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-related-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Zmień', ['update', 'blog_post_id' => $model->blog_post_id, 'blog_related_post_id' => $model->blog_related_post_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Kasuj', ['delete', 'blog_post_id' => $model->blog_post_id, 'blog_related_post_id' => $model->blog_related_post_id], [
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
            'blog_post_id',
            'blog_related_post_id',
        ],
    ]) ?>

</div>
