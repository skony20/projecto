<?php
namespace frontend\widget;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Products;
use Yii;


class CartWidget extends Widget
{

    public $aSessionCart;

    public function init()
    {
        parent::init();
        if ($this->aSessionCart === null) {
            $this->aSessionCart = [];
        }
    }

    public function run()
    {
        $oProducts = new Products();
        $iCartCount = $oProducts->CountCart();

        $sInCart ='
                        <div class="cart" id="cart">

                            <div class="cart-name">Koszyk (<span id="cart-count">'.$iCartCount.'</span>)</div>'.Html::img(Yii::$app->request->BaseUrl.'/img/basket.png', ['class'=>'basket']).'
                                <div class="cart-container">
                                    <div class="cart-items" id="cart-items">';
            $sInCart .= '<table class="in-cart_table">';
            if (count($this->aSessionCart)>0)
            {
                foreach ($this->aSessionCart as $aPrjCart)
                {
                    $sInCart .= '<tr>';
                    $aPrj = $oProducts->findOne($aPrjCart['iPrjId']);
                    $sInCart .= '<td>'.Html::img(yii::getalias("@image").'/'.$aPrjCart['iPrjId'].'/thumbs/'.$aPrj->productsImages[0]->name).'</td><td>'.$aPrjCart['iQty'].'</td><td>x</td><td>'.$aPrj->productsDescriptons->name.'</td>';
                    $sInCart .= '</tr>';
                }
                

                
            }
            else
            {
                $sInCart .= '<tr>';
                $sInCart .= '<td>Brak produktów w koszyku</td>';
                $sInCart .= '</tr>';
            }
        $sInCart .= '</table>';
           $sInCart .= '<br>' .Html::a('Pokaz koszyk', Yii::getAlias("@web").'/cart/') ;
           $sInCart .= '</div>
                   </div>
                   </div>
               </div>';   
           return $sInCart;
    }
}
?>