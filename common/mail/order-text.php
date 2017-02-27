<?php
use yii\helpers\Html;
use yii\i18n\Formatter;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
Dziękujemy za złożenie zamówienia.
Twoje zamówienie zostało przyjęte i jest w trakcie realizacji. O wszystkich zmianach będziemy informowali na podany adres mailowy.

Zamówieni nr: <?= $iOrderId?>



    <?php
    foreach ($aProducts as $aProduct)
    {
    ?>
    <?= $aProduct['prj']->productsDescriptons->name . ' ' .$aProduct['prj']->productsDescriptons->name_model. ' '. $aProduct['prj']->productsDescriptons->name_subname?> x <?= $aProduct['iQty'] ?>  <?= Yii::$app->formatter->asCurrency($aProduct['prj']->price_brutto, ' zł') ?>  <?= Yii::$app->formatter->asCurrency($aProduct['prj']->price_brutto*$aProduct['iQty'], ' zł')?>
    <?php
    }
    ?>
    Metoda płatności  <?= $aPayment->name?>
    Wysyłka Darmowa
    Razem <?= Yii::$app->formatter->asCurrency($aTotal['iTotal'], ' zł')  ?>
    <?php
    if ($aDelivery['comments'] != '')
    {
    ?>
    
    Komentarz do zamówienia: <?= $aDelivery['comments'] ?>
    
    <?php
    }
    ?>
    Dane kontaktowe
    
    adres email: <?= Yii::$app->user->identity->email ?>
    
    nr telefonu: <?= $aDelivery['customer_phone']?>
    
    <?=$aDelivery['delivery_name']. ' ' . $aDelivery['delivery_lastname']  ?>
    <?= $aDelivery['delivery_street_local'] ?>
    <?= $aDelivery['delivery_zip'] . ' ' . $aDelivery['delivery_city'] ?>
    

    <?php
        if ($bIsInvoice)
        {
        ?>
        
            <?=$aDelivery['invoice_nip']  ?>
            <?=$aDelivery['invoice_firm_name']  ?>
            <?=$aDelivery['invoice_name']. ' ' . $aDelivery['invoice_lastname']  ?>
            <?= $aDelivery['invoice_street_local'] ?>
            <?= $aDelivery['invoice_zip'] . ' ' . $aDelivery['invoice_city'] ?>   
        <?php
            }
        ?>
    <?php
    if ($aDelivery['shippings_payments_id'] == 1)
    {
    ?>
    Dane do przelewu

    Kwotę w wysokości: <?=Yii::$app->formatter->asCurrency($aTotal['iTotal'], ' zł')?> przelej na konto:
    
    81 1140 2017 0000 4902 0574 4547
    
    Dane do przelewu:
    ProjektTop.pl
    Wici 48/49
    91-157 Łódź
    Tytuł przelewu: <?= $iOrderId ?>
    <?php
    }
    ?>


