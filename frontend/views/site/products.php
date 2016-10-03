<?php

echo print_r($_POST, TRUE).'<br>';
echo print_r($_SESSION,  TRUE);
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
            <?='<strong>'.$aProducts->productsDescriptons->name .'</strong><br>'. $aProducts->productsDescriptons->name_model ?>
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