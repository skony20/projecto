<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

Witaj <?= Html::encode($user->username) ?>

Poniżej znajduje się link dzięki któremu możesz ustawić nowe hasło dla swojego konta.

<?= Html::a(Html::encode($resetLink), $resetLink) ?>

