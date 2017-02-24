<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title = 'Potwierdzenie zamówienia';
$this->params['breadcrumbs'][] = $this->title;
//echo '<pre>'. print_r($oOrderActual, TRUE); die();
?>
<div class="order-confirm">
    <strong>Dziękujemy za złożone zamówienie.</strong><br><br>
    Twój numer zamówienia to: <span class="order-number"><?= $iOrderId ?></span>

<?php 
if ($oOrderActual['shippings_payments_id'] == 1)
{
?>
    <div class="confirm-payment">
        Kwotę w wysokości: <strong><?=Yii::$app->formatter->asCurrency($oOrderActual['value_brutto'], ' zł')?> </strong>przelej na konto:<br><br>
        81 1140 2017 0000 4902 0574 4547<br><br><br>
        Dane do przelewu:<br><br>
        ProjektTop.pl<br>
        Wici 48/49<br>
        91-157 Łódź<br><br>
        Tytuł przelewu: #<?= $iOrderId ?>
        
    </div>
<?php
}
else if ($oOrderActual['shippings_payments_id'] == 3 && empty($_GET))
{
    ?>
    <form action="<?= $p24Form->getAction() ?>" method="POST">

                <?php foreach ($p24Form->getAttributes() as $name => $value): ?>
                    <?= Html::hiddenInput($name, $value); ?>
                <?php endforeach; ?>

            <?= Html::submitButton('Przejdź do płatności', ['class'=>'blue-button margin-ver-10']) ?>
  </form>
<?php
}
?>
        <br><br>Status zamówienia możesz sprawdzić klikając "Moje konto" > "Zamówienia".<br><br>
</div>
