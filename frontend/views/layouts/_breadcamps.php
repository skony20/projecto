<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
?>
<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<?php
   if(Yii::$app->getSession()->getAllFlashes()) {
      $this->registerJs("$('#system-messages').fadeIn().animate({opacity: 1.0}, 4000). fadeOut('slow');");
   }
?>

<div id="system-messages" style="opacity: 1; display: none">
   <?= Alert::widget(); ?>
</div>