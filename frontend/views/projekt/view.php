<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\web\Request;
$sPatch = Yii::getAlias('@image');
/* @var $this yii\web\View */
/* @var $model app\models\Products */

$sPrjName = $model->productsDescriptons->name . ($model->productsDescriptons->name_model ? ' '.$model->productsDescriptons->name_model: '') . ($model->productsDescriptons->name_subname ? ' ' .$model->productsDescriptons->name_subname : '');
$this->title = $sPrjName .' - projekty domów projekttop.pl';

$this->params['breadcrumbs'][] = ['label' => 'Projekty', 'url' => ['/projekty']];
$this->params['breadcrumbs'][] = $sPrjName ;
$url = Yii::$app->request->absoluteUrl;
?>
<div class="wrap view-gray">    
    <div class="container">
        <h1><?= Html::encode('Projekt domu: '.$sPrjName) ?></h1>
        <div class="prj-share">Podziel się: <?= Html::a('<i class="fa fa-facebook share-icon" aria-hidden="true"></i>', 'https://www.facebook.com/sharer/sharer.php?u='.$url)?><?= Html::a('<i class="fa fa-twitter share-icon" aria-hidden="true"></i>', 'https://twitter.com/home?status='.$url)?><?= Html::a('<i class="fa fa-google-plus share-icon" aria-hidden="true"></i>','https://plus.google.com/share?url='.$url)?><?= Html::a('<i class="fa fa-linkedin share-icon" aria-hidden="true"></i>', 'https://www.linkedin.com/shareArticle?mini=true&url='.$url.'&title='.$this->title.'&summary=&source=projekttop.pl')?></div>
        <div class="green-border"></div>
        <div class="prj-img-price">
            <div class="prj-images">

                    <div id="prci" class="zoom-gallery">
                    <div class="big-image">
                        <img id="fst" src="<?=$sPatch.'/'.$model->id.'/big/'.$model->productsImages[0]->name ?>" alt="Galeria: <?=$sPrjName?><?=($model->productsImages[0]->description ? ' - '.$model->productsImages[0]->description : "")?>"/>
                    </div>
                    <?php
                    if (isset($model->productsImages) && sizeof($model->productsImages) > 0)
                    {
                    ?>
                        <div class="thumbs-imgs">
                        <span class="left"></span><span class="right"></span>
                        <?php
                        $a=0;
                        foreach ($model->productsImages as $aProductsImages)
                        {
                            if ($aProductsImages->image_type_id ==1)
                            {
                        ?>
                                <a id="g<?=$a?>" href="<?=$sPatch.'/'.$model->id.'/big/'.$aProductsImages->name ?>" title="Galeria: <?=$sPrjName?><?=($aProductsImages->description ? ' - '.$aProductsImages->description : "")?>"><img src="<?=$sPatch.'/'.$model->id.'/thumbs/'.$aProductsImages->name ?>" alt="Galeria: <?=$sPrjName?><?=($aProductsImages->description ? ' - '.$aProductsImages->description : "")?>"></a>
                        <?php
                        $a++;
                            }

                        }
                        ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>   
            </div>
        </div>
    </div>
</div>
<div class="wrap view-ligh-blue">    
    <div class="container">
        <div class="products-view">

                <div class="prj-prc">
                    <div class="prj-prc-item "><i class="fa fa-home fa-2x" aria-hidden="true"></i><i class="fa fa-question-circle green-icon" aria-hidden="true"></i><br><span class="m12abk text-uppercase">Powierzchnia użytkowa</span></div>
                    <div class="prj-prc-item view-darker-blue"><span class="m21b"><?= ($aPrdAttrs[4]['value'] ? $aPrdAttrs[4]['value'] .' m2' : 'b/d') ?></span></div>
                    <div class="prj-prc-item"><i class="fa fa-arrows-alt fa-2x" aria-hidden="true"></i><i class="fa fa-question-circle green-icon" aria-hidden="true"></i><br><span class="m12abk text-uppercase">Minimalne<br>wymiary działki</span></div>
                    <div class="prj-prc-item view-darker-blue"><span class="m21b"><?= ($aPrdAttrs[7]['value'] ? round($aPrdAttrs[7]['value']) .' x '.round($aPrdAttrs[6]['value']) .' m' : 'b/d') ?></span></div>
                    <div class="prj-prc-item"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i><br><span class="m12abk text-uppercase">Cena</span></div>
                    <div class="prj-prc-item price-gray m21w"><?= ($model->price_brutto_source != $model->price_brutto ? '<span class="source-price">'.$model->price_brutto_source.'</span><br><span class="price">'. $model->price_brutto. '</span>': '<span class="price">'. $model->price_brutto. ' zł</span>') ?></div>
                    <div class="prj-add-button m13w" rel="<?= $model->id ?>" rel2="<?= $model->productsDescriptons->nicename_link.'.html' ?>">Dodaj do koszyka <i class="fa fa-cart-arrow-down" aria-hidden="true"></i></div>
                </div>
        </div>
    
    </div>
</div>
<div class="wrap">    
    <div class="container">
        <div class="prj-desc">

            <ul class="tabs">
                <li class="tab-link current" data-tab="opis">Opis</li>
                <li class="tab-link" data-tab="dane">Dane techniczne</li>
                <li class="tab-link" data-tab="elewacje">Elewacje</li>
                <li class="tab-link" data-tab="rzuty">Rzuty</li>
                <li class="tab-link" data-tab="realizacje">Realizacje</li>
                <li class="tab-link" data-tab="opinie">Opinie</li>
            </ul>

            <div id="opis" class="tab-content current">
                <?= $model->productsDescriptons->html_description ?>
            </div>
            <div id="dane" class="tab-content">
                <table class="prj-tech-data">
                    <?php
                    foreach ($aSortPrdAttrs as $aTechData)
                    {
                        if ($aTechData['value']!= '' && $aTechData['value']!=0 && $aTechData['value']!=9999)

                        {
                        ?>

                            <tr>
                                <td class="tech-data-name"><?= $aTechData['name']?></td>
                                <td class="tech-data-value"><?= $aTechData['value'] . ' ' . $aTechData['measure']?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
            <div id="elewacje" class="tab-content">
                <?php
                $a=0;
                foreach ($model->productsImages as $aProductsImages)
                {
                    if ($aProductsImages->image_type_id == 2)
                    {
                ?>
                        <?=($aProductsImages->description ? '<div class="prj_images_title">'.$aProductsImages->description.'</div>' : "")?><br><img src="<?=$sPatch.'/'.$model->id.'/big/'.$aProductsImages->name ?>" alt="Elewacja: <?=$sPrjName?><?=($aProductsImages->description ? ' - '.$aProductsImages->description : "")?>"><br>
                    <?php
                    $a++;
                    }

                }
                ?>
            </div>
            <div id="rzuty" class="tab-content">
                <?php
                $a=0;
                foreach ($model->productsImages as $aProductsImages)
                {
                    if ($aProductsImages->image_type_id == 3)
                    {
                ?>
                    <?=($aProductsImages->description ? '<div class="prj_images_title">'.$aProductsImages->description.'</div>' : "")?><br><img src="<?=$sPatch.'/'.$model->id.'/big/'.$aProductsImages->name ?>" alt="Elewacja: <?=$sPrjName?><?=($aProductsImages->description ? ' - '.$aProductsImages->description : "")?>"><br>
                    <?php
                    $a++;
                    }

                }
                ?>
            </div>
            <div id="realizacje" class="tab-content">
                Brak realizacji tego projektu
            </div>
            <div id="opinie" class="tab-content">
                Brak opinie o projekcie<br><br>
                Napisz opinie.
            </div>

        </div>
    </div>
</div>
    
