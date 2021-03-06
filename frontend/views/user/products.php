<?php
use yii\helpers\Html;
use yii\helpers\Url;
if (!$dataProvider->models)
{
    echo 'Brak ulubionych projektów';
}
else 
{    
?>
    <div class="prjs_paso">
    <div class="prjs_sort">Sortuj według: 
        <form id="prj_sort" class="prj_sort" action="">
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
    <div class="prjs_all">
    <?php
    foreach ($dataProvider->models as $aProducts)
    {
    ?>

    <div class="prj_all">
        <div class="prj_title">
            <h2>
                <?= Html::a('<strong>'.$aProducts->productsDescriptons->name .'</strong><br>'. $aProducts->productsDescriptons->name_model, Yii::getAlias('@web').'/projekt/'.$aProducts->id, ['title' => $aProducts->productsDescriptons->name]);?>

            </h2>
        </div>
        <div class="prj_img">
        <img src='<?=yii::getalias("@image")?>/<?=$aProducts->id?>/info/<?=$aProducts->productsImages[0]->name?>' class='prj_image'/>
        </div>
        <div class="prj_price">
            Cena: <?= $aProducts->price_brutto ?>
        </div>

        <div class="prj_del_favorites" rel="<?= $aProducts->id ?>">
            Usuń z ulubionych
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
}
?>
</div>