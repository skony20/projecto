<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Favorites;
use common\models\User;
use common\widgets\Alert;

class FavoritesController extends MetaController
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
                        'actions' => ['add-favorites', 'delete-favorites'],
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
    public function actionAddFavorites($iPrjId)
    {
        $oFavorites = new Favorites();
        $oFavorites->products_id = $iPrjId;
        $oFavorites->user_id = Yii::$app->user->identity->id;  
        $oFavorites->add_data= time();
        $aFavorit = $oFavorites->findAll(['user_id' => Yii::$app->user->identity->id , 'products_id'=>$iPrjId]);
       // echo '<pre>' .print_r($aFavorit, TRUE); die();
        if (count($aFavorit)==0)
        {
            $oFavorites->save();
            Yii::$app->session->setFlash('success', 'Projekt dodany do ulubionych');
        }
        else
        {
            Yii::$app->session->setFlash('error', 'Ten projekt już lubisz');
        }
            
            
    }
    
    
    public function actionDeleteFavorites($iPrjId)
    {
        $oFavorites = new Favorites();
        $aCurrentFavorites = $oFavorites->findOne(['products_id'=>$iPrjId, 'user_id' => Yii::$app->user->identity->id]);
        $aFavoriteToDelete = $oFavorites->findOne($aCurrentFavorites->id);
        if ($aFavoriteToDelete->delete())
        {
            Yii::$app->session->setFlash('success', 'Projekt usunięty z ulubionych');
        }
    }
    public function afterAction($action, $result) 
    {
       if (!empty(Yii::$app->session->getAllFlashes())) {
           echo Alert::widget();
       }
       return parent::afterAction($action, $result);
    }
}
