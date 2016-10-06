<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\Session;

class CartController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['add-cart', 'in-cart', 'reset-cart'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionAddCart($iPrjId)
    {   
        $oSession = new Session();
        $aPrjInCart = ($oSession->get('Cart') ? $oSession->get('Cart'): []);
        
        $iQty =1;
        $iCheckCart = in_array($iPrjId, array_column($aPrjInCart, 'iPrjId'));
        if ($iCheckCart)
        {
            $key = array_search($iPrjId, array_column($aPrjInCart, 'iPrjId'));
            $iQty= $aPrjInCart[$key]['iQty']+1;
            $aPrjInCart[$key]['iQty'] = $iQty;
        }
         else
        {
             array_push($aPrjInCart, array('iPrjId'=>$iPrjId, 'iQty'=>$iQty));
        }
        
        $oSession['Cart'] =$aPrjInCart;
        return $this->renderAjax('AddCart',['CartItems'=>$aPrjInCart]);
        
        
    }

    public function actionResetCart()
    {
        $oSession = new Session();
        $oSession->remove('Cart');
    }
}
