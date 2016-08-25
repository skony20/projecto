<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Filters */

$this->title = Yii::t('app', 'Dodaj odpowiedź');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Odpowiedzi'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filters-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
