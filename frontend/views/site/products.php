<?php
if (!$dataProvider->models)
{
    echo 'Brak projektów spełniajacych kryteria';
}
?>
<div class="prjs_title"><h1>Projekty domów</h1></div>
<div class="prj_sort">
    Formularz sortowania
</div>
<div class="prj_pagi">
    <?php
    echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
    ]);
    ?>
    
</div>
<?php
foreach ($dataProvider->models as $aProducts)
{
?>

<div class="prj_all">
    <div class="prj_title">
        <h2>
            <?=$aProducts->productsDescriptons->name .'  '. $aProducts->productsDescriptons->name_model ?>
        </h2>
    </div>
    <div class="prj_img">
    Obrazek    
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


echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
]);
?>