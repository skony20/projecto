<?php
namespace frontend\widget;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\Session;
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
        if (count($this->aSessionCart) > 0)
        {
            $sInCart = '<table class="in-cart_table">';
            foreach ($this->aSessionCart as $aPrjCart)
            {
                $sInCart .= '<tr>';
                $aPrj = $oProducts->findOne($aPrjCart['iPrjId']);
                $sInCart .= '<td>'.Html::img(yii::getalias("@image").'/'.$aPrjCart['iPrjId'].'/thumbs/'.$aPrj->productsImages[0]->name).'</td><td>'.$aPrjCart['iQty'].'</td><td>x</td><td>'.$aPrj->productsDescriptons->name.'</td>';
                $sInCart .= '</tr>';
            }
            $sInCart .= '</table>';
            $sInCart .= '<br>' .Html::a('Realizuj zamówienie', Yii::getAlias("@web").'/cart/index/') ;
        }
        else
        {
            $sInCart = 'Brak produktów w koszyku';
        }
        return $sInCart;
    }
}
?>