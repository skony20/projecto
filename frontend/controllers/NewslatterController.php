<?php
/* 
Projekt    : projekttop.pl
Created on : 2017-01-06, 11:10:52
Author     : Mariusz Skonieczny mariuszskonieczny@hotmail.com
*/
namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Newslatter;
use common\widgets\Alert;
use yii\swiftmailer\Mailer;
class NewslatterController extends Controller
{
    public function behaviors()
    {
        return [
           'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['add'],
                        'allow' => true,
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

    public function actionAdd($sEmail = '')
    {
        if($sEmail != '')
        {
            $this->checkEmail($sEmail);
        }
        
    }
    public function checkEmail($sEmail)
    {
        $oNewslatter = new Newslatter();
        $IsIn = $oNewslatter->findOne(['email'=>$sEmail]);
        if ($IsIn)
        {
            Yii::$app->session->setFlash('danger', 'Twój adres email został już dodany do naszej bazy');
        }
        else
        {
            $oNewslatter->is_verified =1;
            $oNewslatter->email = $sEmail;
            $oNewslatter->register_date = time();
            $oNewslatter->verified_date = time();
            if ($oNewslatter->save())
            {   
                Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'newslatter-html', 'text' => 'newstaller-text']
                )
                ->setReplyTo(Yii::$app->params['supportEmail'])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo($sEmail)
                ->setSubject('Dziękujemy za zapisanie się na newslatter')
                ->send();
                Yii::$app->session->setFlash('success', 'Dziękujemy! <br>Od teraz będziesz dostawał wszelkie informacje o naszej działaności promocjach i eventach.');
            }
        }
    }  
    public function afterAction($action, $result) 
    {
       if (Yii::$app->request->isAjax && !empty(Yii::$app->session->getAllFlashes())) {
           echo Alert::widget();
       }
       return parent::afterAction($action, $result);
    }
    
    
}