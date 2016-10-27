<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use frontend\models\Account;
use app\models\Orders;
use yii\data\ActiveDataProvider;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = 'account';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['account', 'favorites', 'adress-data', 'change-password', 'orders'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
    public function actionAccount()
    {   

        return $this->render('account');
    }
    public function actionAdressData()
    {
        $oAccount = new Account();
        $oUser = new User(); 
        $aUser = $oUser->findIdentity(Yii::$app->user->identity->id);
        if (Yii::$app->request->post() && $oUser->validate())
        {    
            $oAccount->load(Yii::$app->request->post());
            $oAccount->changeData();
            $aUser = $oUser->findIdentity(Yii::$app->user->identity->id);
        }
        
        return $this->render('adress-data', ['aUser'=>$aUser, 'model'=>$oAccount]);

    }
    public function actionChangePassword()
    {
        $oAccount = new Account();
        $oUser = new User(); 
        $aUser = $oUser->findIdentity(Yii::$app->user->identity->id);
        if (isset(Yii::$app->request->post('Account')['password']) && Yii::$app->request->post('Account')['password'] != '' && $oUser->validate())
        {
            $oAccount->load(Yii::$app->request->post());
            $oAccount->changePassword(false);  
            $aUser = $oUser->findIdentity(Yii::$app->user->identity->id);
        }
        return $this->render('change-password', ['aUser'=>$aUser, 'model'=>$oAccount]);
    }
    public function actionFavorites()
    {   
        
        return $this->render('favorites');
        
        
    }
    public function actionOrders()
    {
        $oUser = new User(); 
        $iUserId = $oUser->findIdentity(Yii::$app->user->identity->id);
        $oOrders = new Orders();
        $query = $oOrders::find()->FilterWhere(['customers_id' => $iUserId->id]);
        $query->joinWith(['ordersPositions']);
        $query->joinWith(['ordersStatus']);
        $query->joinWith(['payment']);
        $query->orderBy(['id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>['pageSize' => 20],
            ]);
        
        //echo '<pre>'. print_r($dataProvider , TRUE); die();
        return $this->render('orders', ['aOrders'=>$dataProvider]);
    }
}
