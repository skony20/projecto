<?php
use yii\helpers\Html;
use yii\helpers\Url;
if (!$dataProvider->models)
{
    
    echo 'Brak projektów spełniajacych kryteria';
}
?>
<div class="prjs-firstline">
    <div class="prjs-count"><span class="o13bb"><?= $dataProvider->totalCount ?></span><span> projektów</span></div>
<div class="prjs-pagi">
    <?php
    echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
    'maxButtonCount'=>4,
    ]);
    ?>
</div>
<div class="prjs-sort">Sortuj: 
    <form id="prj-sort" class="prj-sort" action="">
        <select name="sort">
            <option value="default" <?= ($sort=='default' ? 'selected' :'' ) ?>>Domyślnie</option>
            <option value="price_asc"<?= ($sort=='price_asc' ? 'selected' :'' ) ?>>Ceny od najniższej</option>
            <option value="price_desc"<?= ($sort=='price_desc' ? 'selected' :'' ) ?>>Ceny od najwyższej</option>
            <option value="name_asc"<?= ($sort=='name_asc' ? 'selected' :'' ) ?>>Nazwy A-Z</option>
            <option value="name_desc"<?= ($sort=='name_desc' ? 'selected' :'' ) ?>>Nazwy Z-A</option>
        </select>
    </form>
</div>

</div>
<div class="prjs-all">
<?php
foreach ($dataProvider->models as $aProducts)
{
?>

<div class="prj-all col-md-4 col-sm-6 col-xs-12">
    <div class="prj-img">
    <img src='<?=yii::getalias("@image")?>/<?=$aProducts->id?>/info/<?=$aProducts->productsImages[0]->name?>' class='prj-image'/>
    </div>
    <div class="prj-left">
        <div class="prj-title">
            <h2 class="o12gsm">
                <?= Html::a('Projekt - '.$aProducts->productsDescriptons->name .' '. $aProducts->productsDescriptons->name_model, Yii::getAlias('@web').'/projekt/'.$aProducts->productsDescriptons->nicename_link.'.html', ['title' => 'Projekt domu - '.$aProducts->productsDescriptons->name, 'class'=>'o12gsm']);?>
            </h2>
        </div>
        <div class="prjs-area m18b">
            <?php  $aAttributes = $aProducts->getOneAttribute(4)->all() ?>
            <?= $aAttributes[0]->value ?> m2

        </div>
    </div>
    <div class="prj-right">
        <div class="prj-price m15b">
            <?= str_replace('.00', '', $aProducts->price_brutto) ?> zł
        </div>
        <?= Html::a('<div class="prj-link"></div>', Yii::$app->request->BaseUrl.'/projekt/'.$aProducts->productsDescriptons->nicename_link.'.html') ?>
        <div class="prj-add-favorites" rel="<?= $aProducts->id ?>">
            Ulubiony projekt
        </div>

        <div class="prj-add-cart" rel="<?= $aProducts->id ?>">
            Dodaj do koszyka
        </div>
    </div>
</div>
    
<?php
}
?>
    
</div>
<div class="prjs-pagi">
<?php 
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
    'maxButtonCount'=>4,
]);

?>
</div>