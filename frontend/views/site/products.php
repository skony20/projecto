<?php
use yii\helpers\Html;
use yii\helpers\Url;
if (!$dataProvider->models)
{
    
    echo 'Brak projektów spełniajacych kryteria';
}
?>
<div class="prjs_title"><h1>Projekty domów</h1></div>
<div class="prjs_paso">
<div class="prjs_sort">
    Formularz sortowania
</div>
<div class="prjs_pagi">
    <?php
    echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
    'maxButtonCount'=>10,
    ]);
    ?>
</div>
</div>
<div class="prjs_all">
<?php
foreach ($dataProvider->models as $aProducts)
{
?>

<div class="prj_all">
    <div class="prj_title">
        <h2>
            <?= Html::a('<strong>'.$aProducts->productsDescriptons->name .'</strong><br>'. $aProducts->productsDescriptons->name_model, Yii::getAlias('@web').'/projekt/'.$aProducts->id, ['title' => Yii::t('yii', $aProducts->productsDescriptons->name),]);?>
       
        </h2>
    </div>
    <div class="prj_img">
    <img src='<?=yii::getalias("@image")?>/<?=$aProducts->id?>/info/<?=$aProducts->productsImages[0]->name?>' class='prj_image'/>
    </div>
    <div class="prj_price">
        Cena: <?= $aProducts->price_brutto ?>
    </div>
    <div class="prj_add_cart" rel="<?= $aProducts->id ?>">
        Dodaj do koszyka
    </div>
</div>
    
<?php
}
?>
    
</div>
<div class="prjs_pagi">
<?php 
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
]);

?>
</div>