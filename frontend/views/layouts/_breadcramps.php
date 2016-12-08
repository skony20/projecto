<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>
<div class="container container-breadcrumbs">
<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
</div>
