<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
<div class="password-reset">
    <p>Witaj <?= Html::encode($user->username) ?>,</p>

    <p>Dziekujemy za rejestrację</p>
    <p> Twój login: <?= $user->username ?>

</div>
