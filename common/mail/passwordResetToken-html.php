<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Witaj <?= Html::encode($user->username) ?>,</p>

    <p>Poniżej znajduje się link dzięki któremu możesz ustawić nowe hasło dla swojego konta.</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
