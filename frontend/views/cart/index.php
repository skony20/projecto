<?php
use yii\web\Session;
use yii\i18n\Formatter;
use yii\helpers\Html;
Yii::$app->formatter->locale = 'pl-PL';
$sPatch = Yii::getAlias('@image');
$this->title = Yii::t('app', 'Koszyk');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="cart-list-row cart-list-caption">
    <div class="cart-list1"></div>
    <div class="cart-list2">Projekt</div>
    <div class="cart-list3">Cena</div>
    <div class="cart-list4">Ilość</div>
    <div class="cart-list5">Razem</div>
</div>
<?php      
foreach ($aPrjs as $aPrj)
{
?>
<div class="cart-list-row">
    <div class="cart-list1"><?= Html::img(yii::getalias("@image").'/'. $aPrj['prj']->id.'/thumbs/'.$aPrj['img'][0]->name)?></div>
    <div class="cart-list2"><?= $aPrj['desc']->name  ?></div>
    <div class="cart-list3"><?= Yii::$app->formatter->asCurrency($aPrj['prj']->price_brutto, ' zł')  ?><br><?= ($aPrj['prj']->price_brutto != $aPrj['prj']->price_brutto_source ?'zamiast: '.Yii::$app->formatter->asCurrency($aPrj['prj']->price_brutto_source, ' zł') :'')?></div>
    <div class="cart-list4"><?= $aPrj['iQty'] ?></div>
    <div class="cart-list5"><?= Yii::$app->formatter->asCurrency($aPrj['iQty'] * $aPrj['prj']->price_brutto, ' zł') ?></div>
</div>


<?php
}
?>
<div class="cart-list-row cart-list-bottom">
    <div class="cart-list1"></div>
    <div class="cart-list2"></div>
    <div class="cart-list3">Oszczedzasz: <?= Yii::$app->formatter->asCurrency($aPrj['iTotalSource'] - $aPrj['iTotal'], ' zł') ?></div>
    <div class="cart-list4">Suma zamówienia</div>
    <div class="cart-list5"><?= Yii::$app->formatter->asCurrency($aPrj['iTotal'], ' zł')  ?></div>
</div>