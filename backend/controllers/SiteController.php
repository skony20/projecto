<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use app\models\Products;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'pinterest', 'pintereston'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->view->registerMetaTag([
        'name' => 'description',
        'content' => 'Tutaj znajdziesz dopasowany do swoich potrzeb dom'
            ]);
        return $this->render('index');
    }
    public function actionPinterest()
    {
        $oProducts = new Products();
        $aProducts = $oProducts::find()->where(['is_active'=> 1, 'is_archive'=>0, 'in_pinterest'=>0])->all();
        return $this->render('pinterest',['model'=>$aProducts]);
    }
    public function actionPintereston($id)
    {
        $oProducts = new Products();
        $aProducts = $oProducts->findOne($id);
        $aProducts->in_pinterest = 1;
        $aProducts->save(false);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
       if (!\Yii::$app->user->isGuest) {
          return $this->goHome();
       }

       $model = new LoginForm();
       if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
          return $this->goBack();
       } else {
           return $this->render('login', [
              'model' => $model,
           ]);
       }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
