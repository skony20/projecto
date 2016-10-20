<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Products;

use yii\web\Session;

class CartController extends Controller
{
    /**
     * @inheritdoc
     */
    //public $layout = 'withoutcart';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['add-cart', 'in-cart', 'reset-cart', 'index'],
                        'only' => ['logout', 'signup'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    
                ],
            ],
           'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
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
        $aPrjInCart = ( Yii::$app->session->get('Cart') ?  Yii::$app->session->get('Cart'): []);
        
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
        
        Yii::$app->session['Cart'] =$aPrjInCart;
        return $this->renderAjax('AddCart',['CartItems'=>$aPrjInCart]);
        
        
    }

    public function actionResetCart()
    {
         Yii::$app->session->remove('Cart');
    }
    public function actionIndex()
    {

        $aInCart  = Yii::$app->session->get('Cart');
        $oProducts = new Products();
        $aPrjs = [];
        $iTotal = 0;
        $iTotalSource = 0;
        if (count($aInCart) > 0 )
        {
            foreach ($aInCart as $aPrjInCart)
            {
                $aPrj = $oProducts->findOne($aPrjInCart['iPrjId']);
                $iTotal += $aPrjInCart['iQty'] * $aPrj->price_brutto;
                $iTotalSource += $aPrjInCart['iQty'] * $aPrj->price_brutto_source;
                $aPrjs[$aPrjInCart['iPrjId']]['iQty'] = $aPrjInCart['iQty'];
                $aPrjs[$aPrjInCart['iPrjId']]['prj'] = $aPrj;
                $aPrjs[$aPrjInCart['iPrjId']]['desc'] = $aPrj->productsDescriptons;
                $aPrjs[$aPrjInCart['iPrjId']]['img'] = $aPrj->productsImages;
                $aPrjs[$aPrjInCart['iPrjId']]['iTotal'] = $iTotal;
                $aPrjs[$aPrjInCart['iPrjId']]['iTotalSource'] = $iTotalSource;
                
            }
        $oSession = new Session();
        $oSession['aPrjs'] = $aPrjs;
        }
        return $this->render('index',['aPrjs' => $aPrjs]);
    }
}
