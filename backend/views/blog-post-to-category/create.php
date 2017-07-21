<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BlogPostToCategory */

$this->title = 'Dodaj Blog Post To Category';
$this->params['breadcrumbs'][] = ['label' => 'Blog Post To Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-to-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
