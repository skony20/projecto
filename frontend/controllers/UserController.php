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

class UserController extends Controller
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
                        'actions' => ['account', 'favorites'],
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
    public function actionAccount($action='')
    {   
        $oAccount = new Account();
        $oUser = new User(); 
        $aUser = $oUser->findIdentity(Yii::$app->user->identity->id);
        switch ($action)
        {
            case 'changepassword':
                $oAccount->load(Yii::$app->request->post());
                $oAccount->changePassword();
                //echo '<pre>777'. print_r(Yii::$app->request->post(), TRUE);die();
                return $this->render('account', ['aUser'=>$aUser, 'model'=>$oAccount]);
            default:
                
                return $this->render('account', ['aUser'=>$aUser, 'model'=>$oAccount]);
        }
        
        
        
    }
    
    public function actionFavorites()
    {   
        
        return $this->render('favorites');
        
        
    }
}
