<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2016-12-30, 12:07:24
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
namespace frontend\widget;



use yii\base\Widget;
use yii\helpers\Html;
use app\models\Products;
use app\models\Similar;
use yii\data\ActiveDataProvider;
use Yii;
use yii\i18n\Formatter;


class SimilarWidget extends Widget
{
    public $oSimilar;
    public $iProductId;
    public function init()
    {
        parent::init();
        if ($this->oSimilar === null) {
            $this->oSimilar = [];
        }
        if ($this->iProductId === null) {
            $this->iProductId = '';
        }
        
    }

    public function run()
    {
        //echo 'TU'.$this->iProductId;
        $oProducts = new Products();
        $oSimilars = new Similar();
        $aSimilars = $oSimilars::find()->where(['similar.main_product_id'=>$this->iProductId])->all();
        
        //echo '<pre>'. print_r($aSimilar, TRUE); die();
    ?>
        <div class="wrap wrap-similar">
            <div class="container container-similar">
                <div class="m24b text-center">Podobne projekty</div>
                <div class="center-green-border"></div>
                <div class="col-md-12">
                    <?php 
                    foreach ($aSimilars as $aSimilar)
                    {
                        $aProducts = $aSimilar->products;
                        if ($aProducts->is_active ==1)
                        {
                    ?>
                    
                    <div class="col-md-3">
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
                    
                    }
                    ?>
                </div>
            </div>
        </div>

        
    <?php        
    }
    
}
?>