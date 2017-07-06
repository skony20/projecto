<?php
use yii\helpers\Html;
use yii\i18n\Formatter;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
<div>
    <br>
    <br>
    Szanowny kliencie,<br>
    <br>

    Twoje zamówienie nr. <strong><?= $sOrderCode ?></strong>, złożone <?= date("d-m-y",$iOrderDate)  ?> zmieniło status. <br>
    <br>
    Aktualny status zamówienia: <strong><?= $sStatus ?></strong><br>
    <br>
    Dziękujemy za korzystanie z usług sklepu projektTop.pl. Zapraszamy ponownie!<br><br>
</div>
