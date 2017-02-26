<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body style="font-family: Verdana">
    <?php $this->beginBody() ?>
    <div style="background-color:#f5f9fc;padding:0;">
        <img src="http://mariuszskonieczny.kylos.pl/projecto/img/logo.png" style="padding:5px;"/>
    </div>
    <?= $content ?>
    <br><br>
    <span style="font-size:10px;">Ten mail został wygenerowany automatycznie niema potrzeby odpowiadać na niego.</span>
    <br>
    <div style="background-color:#353a3e; color:#bcc0c4; padding:12px; font-size: 12px;">
    <p>ProjektTop.pl 91-157 Łódź, ul. Wici 48/49, NIP: 7281290050, Nr konta mBank: 81 1140 2017 0000 4902 0574 4547</p>
    <p>Biuro obsługi klienta mail: biuro@projekttop.pl<br>
      Biuro obsługi klienta tel.: 608 44 07 55<br>
      Pracujemy od poniedziałku do piątku, w godzinach od 9.00 do 18.00</p>
    <p>Warunki zakupów: <?= Html::a('Regulamin sklepu','http://mariuszskonieczny.kylos.pl/projecto/regulamin') ?> | <?= Html::a('Zwrot towaru', 'http://mariuszskonieczny.kylos.pl/projecto/zwrot') ?> | <?= Html::a('Polityka prywatności', 'http://mariuszskonieczny.kylos.pl/projecto/polityka-prywatnosci') ?></p>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
