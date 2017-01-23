<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title = 'Potwierdzenie zamówienia';
$this->params['breadcrumbs'][] = $this->title;
//echo '<pre>'. print_r($oOrderActual, TRUE); die();
?>
<div class="order-confirm">
    <strong>Dziękujemy za złożne zamówienie.</strong><br><br>
    Twój numer zamówienia to: <span class="order-number"><?= $iOrderId ?></span>

<?php 
if ($oOrderActual['shippings_payments_id'] == 1)
{
?>
    <div class="confirm-payment">
        Kwotę w wysokości: <strong><?=Yii::$app->formatter->asCurrency($oOrderActual['value_brutto'], ' zł')?> </strong>przelej na konto:<br><br>
        xx xxxx xxxx xxxx xxxx xxxx xxxx xxxxx<br><br><br>
        Dane do przelewu:<br><br>
        ProjektTop.pl<br>
        Wici 48/49<br>
        91-157 Łódź<br><br>
        Tytuł przelewu: #<?= $iOrderId ?>
        
    </div>
<?php
}
?>
        <br><br>Status zamówienia możesz sprawdzić klikając "Moje konto" > "Zamówienia".<br><br>
</div>
