<?php
use yii\web\Session;
use yii\i18n\Formatter;
use yii\helpers\Html;
use yii\helpers\Url;


Yii::$app->formatter->locale = 'pl-PL';
$sPatch = Yii::getAlias('@image');
$this->title = 'Koszyk';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-8">
    <div class="text-center"><h1> Zawartość koszyka</h1></div>
    <div class="center-green-border"></div>
</div>
<div class="col-md-8">

<?php
if (count($aPrjs) > 0)
{
?>
    <table class="cart-table">
    <tr class="cart-list-row cart-list-caption m13b">
        <td>Ilość</td>
        <td></td>
        <td>Projekt</td>
        <td>Cena</td>
        
        <td>Razem</td>
        <td></td>
    </tr>
    <?php      
    foreach ($aPrjs as $aPrj)
    {
    ?>
    <tr class="cart-list-row m13b">
        <td><?= $aPrj['iQty'] ?> x </td>
        <td><?= Html::img(yii::getalias("@image").'/'. $aPrj['prj']->id.'/thumbs/'.$aPrj['img'][0]->name)?></td>
        <td><?= $aPrj['desc']->name  ?></td>
        <td><?= Yii::$app->formatter->asCurrency($aPrj['prj']->price_brutto, ' zł')  ?><br><?= ($aPrj['prj']->price_brutto != $aPrj['prj']->price_brutto_source ?'zamiast: '.Yii::$app->formatter->asCurrency($aPrj['prj']->price_brutto_source, ' zł') :'')?></td>
        <td><?= Yii::$app->formatter->asCurrency($aPrj['iQty'] * $aPrj['prj']->price_brutto, ' zł') ?></td>
        <td class="del-cell"><span class="delete-from-cart" rel = "<?=$aPrj['prj']->id?>">Usuń</span></td>
    </tr>


    <?php
    }
    ?>
    <tr class="cart-list-row cart-list-bottom">

        <td>
            <?= ($aTotal['iTotalSource'] != $aTotal['iTotal'] ? 'Oszczedzasz: '.Yii::$app->formatter->asCurrency($aTotal['iTotalSource'] - $aTotal['iTotal'], '') :'')?>
        </td>
        <td  colspan="3" class="ordert-sum m18b">Suma zamówienia</td>
        <td class="ordert-sum m18b"><?= Yii::$app->formatter->asCurrency($aTotal['iTotal'], ' zł')  ?></td>
        <td></td>
    </tr>
    </table>
    <?= Html::a(Html::button("Idź do kasy", ['class'=>'go-to-step1']), Yii::$app->request->BaseUrl.'/order/step1/'); ?>
    <?= Html::a(Html::button("<i class='fa fa-arrow-left' aria-hidden='true'></i> Powrót do projektów", ['class'=>'cart-goback']), Yii::$app->request->BaseUrl.'/projekty/'); ?>
<?php 
}
else
{
    echo 'Brak produktów w koszyku'; 
    echo '<br>';
    Html::a(Html::button("<i class='fa fa-arrow-left' aria-hidden='true'></i> Powrót do projektów", ['class'=>'cart-goback']), Yii::$app->request->BaseUrl.'/projekty/');
}

?>
</div>
<div class='col-md-4 hidden-sm hidden-xs'>
    <div>
        <div class='cart-left'><i class="fa fa-lock fa-4x" aria-hidden="true"></i></div>
        <div class='cart-right m18b'>Bezpieczne zakupy SSL</div>
    </div>
    <div>
        <div class='cart-left'><i class="fa fa-umbrella fa-4x" aria-hidden="true"></i></div>
        <div class='cart-right m18b'>Gwarancja bezpiecznych zakupów</div>
    </div>
    <div>
        <div class='cart-left'><i class="fa fa-truck fa-4x" aria-hidden="true"></i></div>
        <div class='cart-right m18b'>Darmowa dostawa projektu</div>
    </div>
</div>

