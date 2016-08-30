<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Attributes */

$this->title = Yii::t('app', 'Dodaj atrybut');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Atrybuty'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attributes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>
