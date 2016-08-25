<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Producers */

$this->title = Yii::t('app', 'Dodaj producenta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Producenci'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
