<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPostToCategory */

$this->title = 'Zmień Blog Post To Category: ' . $model->category_id;
$this->params['breadcrumbs'][] = ['label' => 'Blog Post To Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category_id, 'url' => ['view', 'category_id' => $model->category_id, 'post_id' => $model->post_id]];
$this->params['breadcrumbs'][] = 'Zmień';
?>
<div class="blog-post-to-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
