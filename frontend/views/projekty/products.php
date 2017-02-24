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
            <option value="size_asc"<?= ($sort=='size_asc' ? 'selected' :'' ) ?>>Powierzchnia najmniejsze</option>
            <option value="size_desc"<?= ($sort=='size_desc' ? 'selected' :'' ) ?>>Powierzchnia największa</option>
        </select>
    </form>
</div>

</div>
<div class="prjs-all" itemscope itemtype="http://schema.org/Product">
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
                    <?= Html::a('<i class="fa fa-external-link icon-blue prj-hidden-link" aria-hidden="true"  title="Zobacz projekt domu - '.$aProducts->productsDescriptons->name.'"></i>', Yii::$app->request->BaseUrl.'/projekt/'.$aProducts->productsDescriptons->nicename_link.'.html', ['itemprop'=>'url']) ?>
                   
                    
                </div>
            </div>
        </div>
        <span class="helper-img"></span>
    <img itemprop="image" src='<?=yii::getalias("@image")?>/<?=$aProducts->id?>/info/<?=$aProducts->productsImages[0]->name?>' class='prj-image'/>
    </div>
    <div class="prj-info">
        <div class="prj-left">
            <div class="prj-title">
                <h2 class="o12gsm" itemprop="name">
                    <?= Html::a($aProducts->productsDescriptons->name .' '. $aProducts->productsDescriptons->name_model, Yii::getAlias('@web').'/projekt/'.$aProducts->productsDescriptons->nicename_link.'.html', ['title' => 'Projekt domu - '.$aProducts->productsDescriptons->name, 'class'=>'o12gsm', 'itemprop'=>'url']);?>
                </h2>
            </div>
            <div class="prjs-area m18b">
                <?php  $aAttributes = $aProducts->getOneAttribute(4)->all() ?>
                <?= $aAttributes[0]->value ?> m2

            </div>
        </div>
        <div class="prj-right">
            <div class="prj-price m15b" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <span itemprop="price" content="<?=$aProducts->price_brutto?>"><?= str_replace('.00', '', $aProducts->price_brutto) ?></span><span itemprop="priceCurrency" content="PLN"> zł</span>
            </div>
            <?= Html::a('<div class="prj-link" itemprop="url"><i class="fa fa-external-link fa-lg" aria-hidden="true" title="Zobacz projekt domu - '.$aProducts->productsDescriptons->name.'"></i></div>', Yii::$app->request->BaseUrl.'/projekt/'.$aProducts->productsDescriptons->nicename_link.'.html', ['itemprop'=>'url']) ?>
            <?php if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->role ==20)
            {
                echo '<a href="'.Yii::$app->request->BaseUrl.'/backend/web/products/'.$aProducts->id .'" target="_blank">Zobacz w cms-ie</a>';
            }
            ?>
            <br>
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