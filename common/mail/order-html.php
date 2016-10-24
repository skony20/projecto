<?php
use yii\helpers\Html;
use yii\i18n\Formatter;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
<div class="password-reset">
    <p>Witaj <?= $aDelivery['delivery_name']. ' ' . $aDelivery['delivery_lastname'] ?>,</p>

    <p>Dziekujemy za złóżenie zamówienia</p>
    <p> Twóje zamówienie:</p>
    <table>
        <tr>
            <td>Projekt</td>
            <td>Sztuk</td>
            <td>Cena</td>
            <td>Wartość</td>
        </tr>
        
        <?php
        //echo '<pre>'. print_r($aProjects, TRUE); die();
        foreach ($aProducts as $aProduct)
        {
        ?>
        <tr>
            <td><?= $aProduct['prj']->productsDescriptons->name . ' ' .$aProduct['prj']->productsDescriptons->name_model. ' '. $aProduct['prj']->productsDescriptons->name_subname?></td>
            <td><?= $aProduct['iQty'] ?></td>
            <td><?= Yii::$app->formatter->asCurrency($aProduct['prj']->price_brutto, ' zł') ?></td>
            <td><?= Yii::$app->formatter->asCurrency($aProduct['prj']->price_brutto*$aProduct['iQty'], ' zł')?></td>
        </tr>
        
        <?php
        }
        ?>
    </table>
    Twoje zamówienie zostanie wysłane na adres:<br><br>
        <?=$aDelivery['delivery_name']. ' ' . $aDelivery['delivery_lastname']  ?><br>
        <?= $aDelivery['delivery_street_local'] ?><br>
        <?= $aDelivery['delivery_zip'] . ' ' . $aDelivery['delivery_city'] ?><br>
</div>
