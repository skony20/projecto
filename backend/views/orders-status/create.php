<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OrdersStatus */

$this->title = 'Dodaj status zamówienia';
$this->params['breadcrumbs'][] = ['label' => 'Statusy zamówienia', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
