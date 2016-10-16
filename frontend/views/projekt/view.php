<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\web\Request;
$sPatch = Yii::getAlias('@image');
/* @var $this yii\web\View */
/* @var $model app\models\Products */

$sPrjName = $model->productsDescriptons->name . ($model->productsDescriptons->name_model ? ' '.$model->productsDescriptons->name_model: '') . ($model->productsDescriptons->name_subname ? ' ' .$model->productsDescriptons->name_subname : '');
$this->title = 'Projekt: '.$sPrjName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projekty'), 'url' => ['/projekty']];
$this->params['breadcrumbs'][] = $this->title;
$url = Yii::$app->request->absoluteUrl;
?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="prj-share">Podziel się: <?= Html::a('F', 'https://www.facebook.com/sharer/sharer.php?u='.$url)?><?= Html::a('T', 'https://twitter.com/home?status='.$url)?><?= Html::a('G+','https://plus.google.com/share?url='.$url)?> <?= Html::a('LI', 'https://www.linkedin.com/shareArticle?mini=true&url='.$url.'&title='.$this->title.'&summary=&source=projekttop.pl')?></div>
    
    <div class="prj-img-price">
        <div class="prj-images">
            
                <div id="prci" class="zoom-gallery">
                <div class="big-image">
                    <img id="fst" src="<?=$sPatch.'/'.$model->id.'/big/'.$model->productsImages[0]->name ?>"/>
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
                        ?>
                            <a id="g<?=$a?>" href="<?=$sPatch.'/'.$model->id.'/big/'.$aProductsImages->name ?>" title="Galeria: <?=$sPrjName?><?=($aProductsImages->description ? ' - '.$aProductsImages->description : "")?>"><img src="<?=$sPatch.'/'.$model->id.'/thumbs/'.$aProductsImages->name ?>" alt="Galeria: <?=$sPrjName?><?=($aProductsImages->description ? ' - '.$aProductsImages->description : "")?>"></a>
                        <?php
                        $a++;
                        }
                        ?>
                </div>
                <?php
                }
                ?>
        </div>   
    </div>
        <div class="prj-prc">
            <div class="prj-prc-item prj-left left-size">Powierzchnia użytkowa: </div>
            <div class="prj-prc-item prj-right right-size"><?= ($aPrdAttrs[4]['value'] ? $aPrdAttrs[4]['value'] .' m2' : 'b/d') ?></div>
            <div class="prj-prc-item prj-left left-plot-dim">Minimalne wymiary działki: </div>
            <div class="prj-prc-item prj-right right-plot-dim"><?= ($aPrdAttrs[7]['value'] ? $aPrdAttrs[7]['value'] .' x '.$aPrdAttrs[6]['value'] .' m' : 'b/d') ?></div>
            <div class="prj-prc-item prj-left left-price">Cena: </div>
            <div class="prj-prc-item prj-right right-price"><?= ($model->price_brutto_source != $model->price_brutto ? '<span class="source-price">'.$model->price_brutto_source.'</span><br><span class="price">'. $model->price_brutto. '</span>': '<span class="price">'. $model->price_brutto. ' zł</span>') ?></div>
            <div class="prj-add-button" rel="<?= $model->id ?>">Dodaj do koszyka</div>
        </div>
    </div>
    
</div>
    <div class="prj-desc">

            <ul class="tabs">
                <li class="tab-link current" data-tab="opis">Opis</li>
                <li class="tab-link" data-tab="dane">Dane techniczne</li>
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
                    ?>
                        <tr>
                            <td class="tech-data-name"><?= $aTechData['name']?></td>
                            <td class="tech-data-value"><?= $aTechData['value']?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
            <div id="realizacje" class="tab-content">
                Brak realizacji tego projektu
            </div>
            <div id="opinie" class="tab-content">
                Brak opinie o projekcie<br><br>
                Napisz opinie.
            </div>

</div>
