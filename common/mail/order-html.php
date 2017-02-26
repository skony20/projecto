<?php
use yii\helpers\Html;
use yii\i18n\Formatter;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
<div>
<p>Dziękujemy za złożenia zamówienia. <br><br>
Twoje zamówieni zostało przyjęte i jest w trakcie realizacji. O wszystkich zaminach będziemy informowali na podany adres mailowy.</p>

<div style="font-size:22px; font-weight:700; padding:10px 0; background-color:#3c7cae; color:#ffffff; margin-bottom:20px; padding: 5px 20px;"> Zamówieni nr: <strong><?= $iOrderId?></strong></div>


<table style="width:100%;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="border: 1px solid #353a3e; padding:0 10px">Projekt</td>
        <td style="border: 1px solid #353a3e; padding:0 10px">Sztuk</td>
        <td style="border: 1px solid #353a3e; padding:0 10px">Cena</td>
        <td style="border: 1px solid #353a3e; padding:0 10px">Wartość</td>
    </tr>
        
    <?php
    foreach ($aProducts as $aProduct)
    {
    ?>
    <tr>
        <td style="border: 1px solid #353a3e; padding:0 10px"><?= $aProduct['prj']->productsDescriptons->name . ' ' .$aProduct['prj']->productsDescriptons->name_model. ' '. $aProduct['prj']->productsDescriptons->name_subname?></td>
        <td style="border: 1px solid #353a3e; padding:0 10px"><?= $aProduct['iQty'] ?></td>
        <td style="border: 1px solid #353a3e; padding:0 10px"><?= Yii::$app->formatter->asCurrency($aProduct['prj']->price_brutto, ' zł') ?></td>
        <td style="border: 1px solid #353a3e; padding:0 10px"><?= Yii::$app->formatter->asCurrency($aProduct['prj']->price_brutto*$aProduct['iQty'], ' zł')?></td>
    </tr>

    <?php
    }
    ?>
    <tr>
        <td colspan=3 style="text-align:right; border: 1px solid #353a3e; padding:0 10px">Metoda płatności</td>
        <td style="border: 1px solid #353a3e; padding:0 10px"><?= $aPayment->name?></td>
        </tr>
        		<tr>
        <td colspan=3 style="text-align:right; border: 1px solid #353a3e; padding:0 10px">Wysyłka</td>
        <td style="border: 1px solid #353a3e; padding:0 10px">Darmowa</td>
        </tr>
        <tr>
        <td colspan=3 style="text-align:right; border: 1px solid #353a3e; padding:0 10px"><strong>Razem</strong></td>
        <td style="border: 1px solid #353a3e; padding:0 10px"><strong><?= Yii::$app->formatter->asCurrency($aTotal['iTotal'], ' zł')  ?></strong></td>
        </tr>
    </table>
    <?php
    if ($aDelivery['comments'] != '')
    {
    ?>
    <div style="padding:20px; border:1px dashed #353a3e; margin: 10px 0;">
        Komentarz do zamówienia: <i><?= $aDelivery['comments'] ?></i>
    </div>
    <?php
    }
    ?>
    <div style="font-size:22px; font-weight:700; padding:10px 0; background-color:#3c7cae; color:#ffffff; margin:20px 0; padding: 5px 20px;">Dane kontaktowe</div>
    <div>
            adres email: <?= Yii::$app->user->identity->email ?><br>
    <br>
            nr telefonu: <?= $aDelivery['customer_phone']?>
    </div>
    <div style="font-size:22px; font-weight:700; padding:10px 0; background-color:#3c7cae; color:#ffffff; margin:20px 0; padding: 5px 20px;">
	<div style="width:calc(50% - 4px); display:inline-block">Dane do wysyłki</div>
	<div style="width:calc(50% - 4px); display:inline-block">Dane do faktury</div>
    </div>
    <div style="width:calc(50% - 24px); display:inline-block; border:1px dashed #353a3e; padding:10px; margin:0; vertical-align:top">
        <?=$aDelivery['delivery_name']. ' ' . $aDelivery['delivery_lastname']  ?><br>
        <?= $aDelivery['delivery_street_local'] ?><br>
        <?= $aDelivery['delivery_zip'] . ' ' . $aDelivery['delivery_city'] ?><br><br>
    </div>
    <?php
        if ($bIsInvoice)
        {
        ?>
    <div style="width:calc(50% - 24px); display:inline-block; border:1px dashed #353a3e; padding:10px; margin:0; vertical-align:top">
        
            <?=$aDelivery['invoice_nip']  ?><br>
            <?=$aDelivery['invoice_firm_name']  ?><br>
            <?=$aDelivery['invoice_name']. ' ' . $aDelivery['invoice_lastname']  ?><br>
            <?= $aDelivery['invoice_street_local'] ?><br>
            <?= $aDelivery['invoice_zip'] . ' ' . $aDelivery['invoice_city'] ?>   
    </div>
        <?php
            }
        ?>
    <?php
    if ($aDelivery['shippings_payments_id'] == 1)
    {
    ?>
        <div style="font-size:22px; font-weight:700; padding:10px 0; background-color:#3c7cae; color:#ffffff; margin:20px 0; padding: 5px 20px;">Dane do przelewu</div>
        <div>
            Kwotę w wysokości: <strong><?=Yii::$app->formatter->asCurrency($aTotal['iTotal'], ' zł')?> </strong>przelej na konto:<br><br>
            81 1140 2017 0000 4902 0574 4547<br><br>
            Dane do przelewu:<br><br>
            ProjektTop.pl<br>
            Wici 48/49<br>
            91-157 Łódź<br><br>
            Tytuł przelewu: <strong><?= $iOrderId ?></strong>
        </div>
    <?php
    }
    ?>
    </div>
</div>
