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
    <div class="prj-img "rel="<?= $aProducts->id ?>">
        <div class="icon-hide prjs-<?= $aProducts->id ?>">
            <div class="icon-hide-cont">
                <div class=" inline-block">
                    <i class="fa fa-heart-o icon-blue prj-add-favorites" aria-hidden="true" title='Dodaj do ulubionych' rel="<?= $aProducts->id ?>"></i>
                </div>
                <div class="inline-block">
                    <i class="fa fa-cart-arrow-down icon-blue prj-add-cart" aria-hidden="true" title='Dodaj do koszyka' rel="<?= $aProducts->id ?>"></i>
                </div>
                <div class="inline-block">
                    <?= Html::a('<i class="fa fa-external-link icon-blue prj-hidden-link" aria-hidden="true"  title="Zobacz projekt domu - '.$aProducts->productsDescriptons->name.'"></i>', Yii::$app->request->BaseUrl.'/projekt/'.$aProducts->productsDescriptons->nicename_link.'.html') ?>
                   
                    
                </div>
            </div>
        </div>
        <span class="helper-img"></span>
    <img src='<?=yii::getalias("@image")?>/<?=$aProducts->id?>/info/<?=$aProducts->productsImages[0]->name?>' class='prj-image'/>
    </div>
    <div class="prj-info">
        <div class="prj-left">
            <div class="prj-title">
                <h2 class="o12gsm">
                    <?= Html::a($aProducts->productsDescriptons->name .' '. $aProducts->productsDescriptons->name_model, Yii::getAlias('@web').'/projekt/'.$aProducts->productsDescriptons->nicename_link.'.html', ['title' => 'Projekt domu - '.$aProducts->productsDescriptons->name, 'class'=>'o12gsm']);?>
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
            <?= Html::a('<div class="prj-link"><i class="fa fa-external-link fa-lg" aria-hidden="true" title="Zobacz projekt domu - '.$aProducts->productsDescriptons->name.'"></i></div>', Yii::$app->request->BaseUrl.'/projekt/'.$aProducts->productsDescriptons->nicename_link.'.html') ?>
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