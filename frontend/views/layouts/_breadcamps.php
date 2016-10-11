<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
?>
<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>