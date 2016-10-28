<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Products;
use common\widgets\Alert;

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
                        'actions' => ['add-cart', 'in-cart', 'reset-cart', 'index', 'remove-from-cart'],
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

        if (isset($aPrjInCart[$iPrjId]))
        {
            $aPrjInCart[$iPrjId]['iQty'] += 1;
        }
         else
        {
             $aPrjInCart[$iPrjId] = array('iPrjId'=>$iPrjId, 'iQty'=>$iQty);
        }
        
        Yii::$app->session['Cart'] =$aPrjInCart;
        Yii::$app->session->setFlash('success', 'Projekt dodany do koszyka');
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
        $aTotal =[];
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


            }
        $oSession = new Session();
        $oSession['aPrjs'] = $aPrjs;
        $aTotal['iTotal'] = $iTotal;
        $aTotal['iTotalSource'] = $iTotalSource;
        $oSession['aTotal'] = $aTotal;
        }
        return $this->render('index',['aPrjs' => $aPrjs, 'aTotal'=>$aTotal]);

    }
    public function actionRemoveFromCart($iPrjId)
    {
        $aInCart = Yii::$app->session->get('Cart');
        
        unset($aInCart[$iPrjId]);
        Yii::$app->session['Cart'] = $aInCart; 
        Yii::$app->session->setFlash('success', 'Projekt usunięty z koszyka');
        
    }
    public function afterAction($action, $result) 
    {
       if (!empty(Yii::$app->session->getAllFlashes())) {
           echo Alert::widget();
       }
       return parent::afterAction('AddFavorites', $result);
    }
}
