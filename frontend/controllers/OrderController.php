<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Products;
use common\models\User;
use app\models\Orders;
use yii\web\Session;
use app\models\PaymentsMethod;


class OrderController extends Controller
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
                        'actions' => ['step1', 'step2'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
    public function actionStep1()
    {   
        $oUser = new User(); 
        $oOrder = new Orders();
        $aUser = $oUser->findIdentity(Yii::$app->user->identity->id);
        return $this->render('/order/step1',['aUser'=>$aUser, 'aOrder'=>$oOrder]); 
    }

    public function actionStep2()
    {   
        //$aData = [];
        $oSession = new Session();
        $aProducts = $oSession->get('aPrjs');
        $aOrderData = $oSession['OrderData'] = Yii::$app->request->post();
        $oPayment = new PaymentsMethod();
        $aPayment = $oPayment->findOne($aOrderData['Orders']['shippings_payments_id']);
        
        return $this->render('/order/step2', ['aProducts' => $aProducts, 'aOrderData' =>$aOrderData, 'aPayment'=>$aPayment]);
        
        
    }
}
