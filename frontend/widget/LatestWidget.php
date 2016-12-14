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
    
    public function init()
    {

    }

    public function run()
    {
        $oProducts = new Products();
        $aProducts = $oProducts->find()->orderBy(['id' => SORT_DESC])->limit(4)->all();
        
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
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="latest-product">
                    <div class="latest-img"><?= Html::img(yii::getalias("@image").'/'.$aProduct->id.'/info/'.$aProduct->productsImages[0]->name) ?></div>
                    <div class="latest-info">
                        <div class="latest-left">
                            <div class="latest-name o13g-sb"><?= $aProduct->productsDescriptons->name ?><br></div>
                            /*Sprawdzić atrybuty*/
                            <div class="latest-area m18b"><?= $aProduct->productsAttributes[4]->value ?> m2</div>
                        </div>
                        <div class="latest-right">
                            <div class="latest-price m15wgreen"><?=$aProduct->price_brutto. ' zł' ?></div>
                            <div class="latest-link"><?= Html::a(Html::img(Yii::$app->request->BaseUrl.'/img/link-blue.png'), Yii::$app->request->BaseUrl.'/projekt/'.$aProduct->productsDescriptons->nicename_link.'.html') ?></div>
                        </div>
                        
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><?= Html::img(Yii::$app->request->BaseUrl.'/img/tech-stories.png')?> Ilość pięter</div>
                        <div class="latest-right tech-data"><?= $sStories ?></div>
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><?= Html::img(Yii::$app->request->BaseUrl.'/img/tech-bedroom.png')?> Ilość sypialni</div>
                        <div class="latest-right tech-data"><?= (isset($aProduct->productsAttributes[17]->value)? $aProduct->productsAttributes[17]->value : 'b/d')?></div>
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><?= Html::img(Yii::$app->request->BaseUrl.'/img/tech-bathroom.png')?> Ilość łazienek</div>
                        <div class="latest-right tech-data"><?= (isset($aProduct->productsAttributes[18]->value)? $aProduct->productsAttributes[18]->value : 'b/d')?></div>
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><?= Html::img(Yii::$app->request->BaseUrl.'/img/tech-size.png')?> Szerokość</div>
                        <div class="latest-right tech-data"><?= (isset($aProduct->productsAttributes[2]->value)? $aProduct->productsAttributes[2]->value .' m' : 'b/d')?></div>
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><?= Html::img(Yii::$app->request->BaseUrl.'/img/tech-size.png')?> Długość</div>
                        <div class="latest-right tech-data"><?= (isset($aProduct->productsAttributes[3]->value)? $aProduct->productsAttributes[3]->value .' m' : 'b/d')?></div>
                    </div>
                    <div class="latest-tech-data">
                        <div class="latest-left tech-data"><?= Html::img(Yii::$app->request->BaseUrl.'/img/tech-style.png')?> Styl domu</div>
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