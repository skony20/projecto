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
        $iPrjsSum = 0;
        $sInCart ='
                        <div class="cart" id="cart">

                            <div class="cart-name">'.Html::a("Koszyk", Yii::getAlias("@web").'/cart/').'(<span id="cart-count">'.$iCartCount.'</span>)</div><div class="inline-block"><i class="fa fa-shopping-cart icon-gray" aria-hidden="true"></i></div>
                                <div class="cart-container">
                                    <div class="cart-items" id="cart-items">';
            $sInCart .= '<table class="in-cart_table">';
            if (count($this->aSessionCart)>0)
            {
                foreach ($this->aSessionCart as $aPrjCart)
                {
                    $sInCart .= '<tr>';
                    $aPrj = $oProducts->findOne($aPrjCart['iPrjId']);
                    $sInCart .= '<td class="cart-wid-qty">'.$aPrjCart['iQty'].'</td><td class="cart-wid-qty-x">x</td><td class="cart-wid-img">'.Html::img(yii::getalias("@image").'/'.$aPrjCart['iPrjId'].'/thumbs/'.$aPrj->productsImages[0]->name).'</td><td class="cart-wid-name">'.$aPrj->productsDescriptons->name.'</td><td class="cart-wid-price">'.Yii::$app->formatter->asCurrency($aPrj->price_brutto, ' zł'). '</td>';
                    $sInCart .= '</tr>';
                    $iPrjsSum += $aPrj->price_brutto;
                }
                

                
            }
            else
            {
                $sInCart .= '<tr>';
                $sInCart .= '<td colspan="5">Brak produktów w koszyku</td>';
                $sInCart .= '</tr>';
            }
            $sInCart .= '<tr><td colspan="3" class="cart-wid-prjsum">Łaczna wartość:</td><td colspan="2" class="cart-wid-pricesum">'.Yii::$app->formatter->asCurrency($iPrjsSum, ' zł').'</td></tr>';
            $sInCart .= '</table>';
            $sInCart .= '<br>' .Html::a('Przejdź do koszyka <i class="fa fa-caret-right" aria-hidden="true"></i>', Yii::getAlias("@web").'/cart/');
            $sInCart .= '</div>
                   </div>
                   </div>
               </div>';   
           return $sInCart;
    }
}
?>