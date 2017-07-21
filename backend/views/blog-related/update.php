<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogRelated */

$this->title = 'Zmień Blog Related: ' . $model->blog_post_id;
$this->params['breadcrumbs'][] = ['label' => 'Blog Relateds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->blog_post_id, 'url' => ['view', 'blog_post_id' => $model->blog_post_id, 'blog_related_post_id' => $model->blog_related_post_id]];
$this->params['breadcrumbs'][] = 'Zmień';
?>
<div class="blog-related-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
