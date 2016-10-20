<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Zamówienie krok 2 z 2';
$this->params['breadcrumbs'][] = ['label' => 'Koszyk', 'url' => ['/cart']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
//echo '<pre>' . print_r ($aProducts, TRUE)
?>
<div class="order-step2">
 
    <div class="row-order">
        <div class="caption">Twoje zakupy:</div>
        <div>
            <div class="cart-list-row cart-list-caption">
                <div class="cart-list1"></div>
                <div class="cart-list2">Projekt</div>
                <div class="cart-list3">Cena</div>
                <div class="cart-list4">Ilość</div>
                <div class="cart-list5">Razem</div>
            </div>
            <?php 
            foreach ($aProducts as $aProduct)
            {
            ?>
            <div class="order-list-row">
                <div class="cart-list1"><?= Html::img(yii::getalias("@image").'/'. $aProduct['prj']->id.'/thumbs/'.$aProduct['img'][0]->name)?></div>
                <div class="cart-list2"><?= $aProduct['desc']->name  ?></div>
                <div class="cart-list3"><?= Yii::$app->formatter->asCurrency($aProduct['prj']->price_brutto, ' zł')  ?><br><?= ($aProduct['prj']->price_brutto != $aProduct['prj']->price_brutto_source ?'zamiast: '.Yii::$app->formatter->asCurrency($aProduct['prj']->price_brutto_source, ' zł') :'')?></div>
                <div class="cart-list4"><?= $aProduct['iQty'] ?></div>
                <div class="cart-list5"><?= Yii::$app->formatter->asCurrency($aProduct['iQty'] * $aProduct['prj']->price_brutto, ' zł') ?></div>
            </div>
            <?php
            }
            ?>
            <div class="cart-list-row cart-list-bottom">
                <div class="cart-list1"></div>
                <div class="cart-list2"></div>
                <div class="cart-list3">
                    
                </div>
                <div class="cart-list4">Koszt dostawy</div>
                <div class="cart-list5"><?= Yii::$app->formatter->asCurrency(0, ' zł')  ?></div>
            </div>
            <div class="cart-list-row cart-list-bottom">
                <div class="cart-list1"></div>
                <div class="cart-list2"></div>
                <div class="cart-list3">
                    <?= ($aProduct['prj']->price_brutto != $aProduct['prj']->price_brutto_source ? 'Oszczedzasz: '.Yii::$app->formatter->asCurrency($aProduct['iTotalSource'] - $aProduct['iTotal'], '') :'')?>
                </div>
                <div class="cart-list4">Do zapłaty</div>
                <div class="cart-list5"><?= Yii::$app->formatter->asCurrency($aProduct['iTotal'], ' zł')  ?></div>
            </div>
        </div>
    </div>
    <div class="row-order">
        <div class="caption">Metoda płatności:</div>
        <div>
            
        </div>
    </div>
    <div class="row-order">
        <div class="caption">Adres wysyłki:</div>
        <div></div>
    </div>
    <div class="row-order">
        <div class="caption">Uwagi do zamówienia:</div>
        <div></div>
    </div>
</div>