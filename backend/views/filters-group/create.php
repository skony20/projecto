<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FiltersGroup */

$this->title = Yii::t('app', 'Dodaj pytanie');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pytania'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filters-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
