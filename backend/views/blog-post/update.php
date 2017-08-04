<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPost */

$this->title = 'Zmień post: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posty', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Zmień';
?>
<div class="blog-post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'oBlogPostToCategory' =>$oBlogPostToCategory,
        'oBlogTag' => $oBlogTag,
    ]) ?>

</div>
