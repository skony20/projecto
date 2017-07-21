<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogComment */

$this->title = 'Zmień komentarz: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Komentarze', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Zmień';
?>
<div class="blog-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
