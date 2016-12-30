<?php
namespace frontend\widget;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Products;
use yii\data\ActiveDataProvider;
use Yii;
use yii\i18n\Formatter;


class LatestWidget extends Widget
{
    public $limit;
    public function init()
    {
        parent::init();
        if ($this->limit === null) {
            $this->limit = 4;
        }
    }

    public function run()
    {
        $oProducts = new Products();
        $aProducts = $oProducts->find()->orderBy(['id' => SORT_DESC])->limit($this->limit)->all();
        
        //echo '<pre>'. print_r($aProducts, TRUE); die();
        foreach ($aProducts as $aProduct)
        {
           // echo '<pre>'. print_r($aProduct->productsFilters['filters_id'], TRUE); die();
            foreach ($aProduct->productsFilters AS $iFilter)
            {
                switch ($iFilter->filters_id)
                {
                    default:
                        $sStyle = 'b/d';
                        $sStories = 'b/d';
                        break;
                    case 17: 
                        $sStories = '1';
                        break;
                    case 18: 
                        $sStories = '2';
                        break;
                    case 18: 
                        $sStories = '2 lub więcej';
                        break;
                    case 15: 
                        $sStyle = 'Tradycyjny';
                        break;
                     case 16: 
                        $sStyle = 'Nowoczesny';
                        break;
                    
                }
            }
        ?>
            <?php  
            $aRooms = $aProduct->getOneAttribute(17)->all(); 
            $aBatchRooms = $aProduct->getOneAttribute(18)->all();
            $aWidth = $aProduct->getOneAttribute(2)->all();
            $aDepth = $aProduct->getOneAttribute(3)->all();
                    
            ?>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="latest-product">
                    <div class="latest-img"><?= Html::img(yii::getalias("@image").'/'.$aProduct->id.'/info/'.$aProduct->productsImages[0]->name) ?></div>
                    <div class="latest-info">
                        <div class="latest-left">
                            <div class="latest-name o13g-sb"><?= $aProduct->productsDescriptons->name ?><br></div>

                            <div class="latest-area m18b">
                             <?php  $aAttributes = $aProduct->getOneAttribute(4)->all() ?>
                             <?= $aAttributes[0]->value ?> m2

                            </div>
                        </div>
                        <div class="latest-right">
                            <div class="latest-price m15wgreen"><?=$aProduct->price_brutto. ' zł' ?></div>
                            <div class="latest-link"><?= Html::a('<i class="fa fa-external-link fa-lg" aria-hidden="true"></i>', Yii::$app->request->BaseUrl.'/projekt/'.$aProduct->productsDescriptons->nicename_link.'.html') ?></div>
                        </div>
                        
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><i class="fa fa-home" aria-hidden="true"></i>Ilość pięter</div>
                        <div class="latest-right tech-data"><?=$sStories ?></div>
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><i class="fa fa-bed" aria-hidden="true"></i>Ilość sypialni</div>
                        <div class="latest-right tech-data"><?=(isset($aRooms)? $aRooms[0]->value : 'b/d')?></div>
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><i class="fa fa-shower" aria-hidden="true"></i>Ilość łazienek</div>
                        <div class="latest-right tech-data"><?=(isset($aBatchRooms)? $aBatchRooms[0]->value : 'b/d')?></div>
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><i class="fa fa-arrows-alt" aria-hidden="true"></i>Szerokość</div>
                        <div class="latest-right tech-data"><?=(isset($aWidth)? $aWidth[0]->value : 'b/d')?></div>
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><i class="fa fa-arrows-alt" aria-hidden="true"></i>Głębokość</div>
                        <div class="latest-right tech-data"><?=(isset($aDepth)? $aDepth[0]->value : 'b/d')?></div>
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><i class="fa fa-university" aria-hidden="true"></i>Styl domu</div>
                        <div class="latest-right tech-data"><?= $sStyle ?></div>
                    </div>
                </div>
                    
            </div>
        <?php
        
        }
        //echo '<pre>'. print_r($aProduct->productsFilters, TRUE); die();
    }
    
}
?>