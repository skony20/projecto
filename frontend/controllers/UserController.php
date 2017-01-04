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
use app\models\Favorites;
use app\models\Products;

class UserController extends MetaController
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
    public function actionFavorites($sort = 'default')
    {   
        $aProducts = [];
        $aProducts[0] = 0;
        $oFavorites = new Favorites();
        $oProducts = new Products();
        switch ($sort)
        {
            case 'default':
                $aSort = ['producers.sort_order'=> SORT_ASC , 'products.price_brutto' => SORT_ASC];
                break;
            case 'price_asc':
                $aSort = ['products.price_brutto' => SORT_ASC, 'producers.sort_order'=> SORT_ASC];
                break;
            case 'price_desc':
                $aSort = ['products.price_brutto' => SORT_DESC, 'producers.sort_order'=> SORT_ASC];
                break;
            case 'name_asc':
                $aSort = ['products_descripton.name' => SORT_ASC];
                break;
            case 'name_desc':
                $aSort = ['products_descripton.name' => SORT_DESC];
                break;
        }
        $aFavorites = $oFavorites::find(['user_id' => Yii::$app->user->identity->id])->select('products_id')->all();
        foreach ($aFavorites as $aFavorite)
        {
            $aProducts[] .= $aFavorite->products_id;
        }
        $query = $oProducts::find()->FilterWhere(['IN', 'products.id', $aProducts]);
        $query->joinWith('producers');
        $query->joinWith('productsDescriptons');
        $query->orderBy($aSort);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>['pageSize' => 20],
            ]);
        return $this->render('favorites', ['dataProvider' => $dataProvider, 'sort'=>$sort]);
        
        
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
            ]);
        
        //echo '<pre>'. print_r($dataProvider , TRUE); die();
        return $this->render('orders', ['aOrders'=>$dataProvider]);
    }
}
