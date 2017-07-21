<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BlogTag */

$this->title = 'Dodaj tag';
$this->params['breadcrumbs'][] = ['label' => 'Tagi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
