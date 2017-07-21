<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BlogRelated */

$this->title = 'Dodaj Blog Related';
$this->params['breadcrumbs'][] = ['label' => 'Blog Relateds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-related-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
