<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use app\models\FiltersGroup;
use app\models\Filters;
use app\models\ProductsSearch;
use yii\data\ActiveDataProvider;
use app\models\ProductsFilters;
use yii\web\Session;

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
                'only' => ['logout', 'signup'],
                'rules' => [
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {


        $aX = [];
        $aY = [];
        $model = new ProductsSearch();
        $oSession = new Session();
        $oSession['aDimensions'] = [];
        $oSession['aFiltersSession'] = [];
        $oFiltersGroup = new FiltersGroup();
        $oFilters = new Filters();
        $aFiltersData = [];
        $aDimensions = [];
        
        $query = $model::find();
        $query->joinWith(['productsFilters']);
        $query->joinWith(['productsAttributes']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                    ]
                ]
            ]);

        $iMinSize = floor($query->onCondition(['attributes_id'=>4])->min('(CAST(value AS DECIMAL (5,2)))'));
        $iMaxSize = ceil($query->onCondition(['attributes_id'=>4])->max('(CAST(value AS DECIMAL (5,2)))'));

        $iMaxX = ceil($query->onCondition(['attributes_id'=>7])->max('(CAST(value AS DECIMAL (5,2)))'));
        $iMaxY = ceil($query->onCondition(['attributes_id'=>6])->max('(CAST(value AS DECIMAL (5,2)))'));
        
        $aDimensions['iAllMinSize'] = $iMinSize;
        $aDimensions['iAllMaxSize'] = $iMaxSize;
              
        $aPostData = Yii::$app->request->post();
        
        $iPostMinSize = $iMinSize ;
        $iPostMaxSize = $iMaxSize;
        
        //echo '<pre>'.print_r($aPostData , true); die();
        $bBarChange = $oSession->get('BarChange');
        if (isset($aPostData['bar_size']) && $bBarChange)
        {
            
            $aAllSize = explode(';', $aPostData['bar_size']);
            $iPostMinSize = $aAllSize[0];
            $iPostMaxSize = $aAllSize[1];
            
        }
        
        $iMaxX = (isset($aPostData['SizeX']) ? $aPostData['SizeX'] : $iMaxX );
        $iMaxY = (isset($aPostData['SizeY']) ? $aPostData['SizeY'] : $iMaxY );
        $aDimensions['iMaxX'] = $iMaxX;
        $aDimensions['iMaxY'] = $iMaxY;
        $aPostData['SizeX']='';
        $aPostData['SizeY']='';
        //echo $iMinX .'  -  '. $iMinY; die();
        //echo '<pre>'.print_r($aPostData , true); die();
        if ($aPostData && $aPostData>4)
        {
            foreach ($aPostData  as $Filters)
            {
                if (is_numeric($Filters))
                {
                    $aFiltersData[] .= $Filters;
                }
            }
            if ($aFiltersData)
            {
                $query->andFilterWhere(['IN', 'products_filters.filters_id',$aFiltersData])->groupBy('id')->having('COUNT(*)='.count($aFiltersData) );
            }
        }
        
        $query->onCondition('products_attributes.id IN (SELECT products_attributes.id FROM products_attributes WHERE ((value BETWEEN '.$iPostMinSize.' AND '.$iPostMaxSize.' ) AND (attributes_id = 4 ) OR ((value < '.$iMaxX.') AND (attributes_id =7)) OR ((value <'.$iMaxY.' ) AND (attributes_id =6))) GROUP BY products_attributes.products_id 
HAVING COUNT(DISTINCT products_attributes.value)=3)');
       // echo '<pre>'.print_r($dataProvider, true); die();
        $sProjectCount = $dataProvider->count;

        $iOneMinSize = floor($query->select('products_attributes.*')->onCondition(['attributes_id'=>4])->min('(CAST(value AS DECIMAL (5,2)))'));
        $iOneMaxSize = ceil($query->select('products_attributes.*')->onCondition(['attributes_id'=>4])->max('(CAST(value AS DECIMAL (5,2)))'));
        
        
        
        $aDimensions['iOneMinSize'] = ($bBarChange ? $iPostMinSize : $iOneMinSize);
        $aDimensions['iOneMaxSize'] = ($bBarChange ? $iPostMaxSize : $iOneMaxSize);
        

        
        $aFiltersGroup = $oFiltersGroup::find()->where(['is_active'=> 1])->orderBy('sort_order')->all();
        foreach ($aFiltersGroup as $_aFiltersGroup)
        {
            $aFilters = $oFilters::find()->where(['filters_group_id' => $_aFiltersGroup->id, 'is_active'=> 1])->all();
            $aData[$_aFiltersGroup->id] = ['question'=>$_aFiltersGroup, 'answer' => $aFilters];
        }
       
        $oSession['aDimensions'] = $aDimensions;
        //echo '<pre>'. print_r($oSession['aDimensions'], TRUE); die();
        $oSession['aFiltersSession'] = $aFiltersData;
        
        return $this->render('index', ['model' => $model,'sProjectCount' => $sProjectCount, 'aFilters'=>$aData, 'aFiltersData' => $aFiltersData, 'dataProvider'=>$dataProvider, 'aDimensions'=> $aDimensions]);
    }
    
    /**/
    
    
    /**/
    
    
    public function actionProjekty()
    {
        
        $model = new ProductsSearch();
        $oSession = new Session();
        $dataProvider = '';
        $aFiltersData = $oSession->get('aFiltersSession');
        $aDimensions = $oSession->get('aDimensions');
        $aDataFromBarSize = $oSession->get('DataFromBarSize');
        //echo 'Filter'.print_r($oSession->get('aDimensions') , TRUE).'<br>'; die();
        
        $oFiltersGroup = new FiltersGroup();
        $oFilters = new Filters();
        $aFiltersGroup = $oFiltersGroup::find()->where(['is_active'=> 1])->orderBy('sort_order')->all();

        foreach ($aFiltersGroup as $_aFiltersGroup)
        {
            $aFilters = $oFilters::find()->where(['filters_group_id' => $_aFiltersGroup->id, 'is_active'=> 1])->all();
            $aData[$_aFiltersGroup->id] = ['question'=>$_aFiltersGroup, 'answer' => $aFilters];
        }
        $query = $model::find()->distinct();

        $query->joinWith(['productsFilters']);
        $query->joinWith(['productsAttributes']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>['pageSize' => 20],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                    ]
                ]
            ]);
        $bBarChange = $oSession->get('BarChange');
        if(!isset($aDimensions))
        {
            $iMinSize = floor($query->onCondition(['attributes_id'=>4])->min('(CAST(value AS DECIMAL (5,2)))'));
            $iMaxSize = ceil($query->onCondition(['attributes_id'=>4])->max('(CAST(value AS DECIMAL (5,2)))')); 
            $iMaxX = ceil($query->onCondition(['attributes_id'=>7])->max('(CAST(value AS DECIMAL (5,2)))'));
            $iMaxY = ceil($query->onCondition(['attributes_id'=>6])->max('(CAST(value AS DECIMAL (5,2)))'));
            $aDimensions['iAllMinSize'] = $iMinSize;
            $aDimensions['iAllMaxSize'] = $iMaxSize;
            $aDimensions['iMaxX'] =$iMaxX ;
            $aDimensions['iMaxY'] =$iMaxY ;
            $aDimensions['iOneMinSize'] = $iMinSize;
            $aDimensions['iOneMaxSize'] = $iMaxSize;
            $iPostMinSize = $iMinSize;
            $iPostMaxSize = $iMaxSize;
            
        }
        else
        {
            
            $iMaxX = $aDimensions['iMaxX'];
            $iMaxY = $aDimensions['iMaxY'];
            $iPostMinSize = $aDimensions['iOneMinSize'];
            $iPostMaxSize = $aDimensions['iOneMaxSize'];
        }
        if (Yii::$app->request->post())
        {

            $aPostData = Yii::$app->request->post();
            //echo 'Post'.print_r($aPostData, TRUE).'<br>';die();
            /*Zmiana inputów z rozmiarami dzialki*/
            $iMaxX = $aPostData['SizeX'];
            $iMaxY = $aPostData['SizeY'];
            $aDimensions['iMaxX'] =$iMaxX ;
            $aDimensions['iMaxY'] =$iMaxY ;
            $aPostData['SizeX'] = [''];
            $aPostData['SizeY'] = [''];
            /*Zmiana paska wielkości domu*/
            
            
            
            
            if (isset($aPostData['bar_size']) && $bBarChange)
            {

                $aAllSize = explode(';', $aPostData['bar_size']);
                $iPostMinSize = $aAllSize[0];
                $iPostMaxSize = $aAllSize[1];
                
                        

            }
            //echo print_r($aDimensions, TRUE); die();
            
            
            
            /*Zmiana selectów z odpowiedziami */
            $aFiltersData=[];
            foreach ($aPostData  as $Filters)
            {
                if (is_numeric($Filters))
                {
                    $aFiltersData[] .= $Filters;
                }
            }
            $oSession['aFiltersSession'] = $aFiltersData;
            $oSession['aDimensions'] = $aDimensions;
        }
        if ($aFiltersData)
        {
            $query->andFilterWhere(['IN', 'products_filters.filters_id',$aFiltersData])->groupBy('id')->having('COUNT(*)='.count($aFiltersData));
            

        }
        $query->andWhere('products_attributes.id IN (SELECT products_attributes.id FROM products_attributes WHERE ((value BETWEEN '.$iPostMinSize.' AND '.$iPostMaxSize.' ) AND (attributes_id = 4 ) OR ((value < '.$iMaxX.') AND (attributes_id =7)) OR ((value <'.$iMaxY.' ) AND (attributes_id =6))) GROUP BY products_attributes.products_id 
HAVING COUNT(DISTINCT products_attributes.value)=3)');
        

        if (Yii::$app->request->isAjax)
        {
            return $this->renderAjax('products', ['dataProvider'=>$dataProvider]);
        }
        else
        {
             return $this->render('projekty',['aChooseFilters'=>$aFiltersData, 'aFilters'=>$aData, 'dataProvider'=>$dataProvider, 'aDimensions'=>$aDimensions]);
        }



    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionReset()
    {
        $aSession = new Session();
        $aSession->removeAll();

    }
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    public function actionAddToSession($id)
    {
        $oSession = new Session();
        $oSession->setTimeout(1440);
        $oSession[$id] = Yii::$app->request->post();
    }
    public function actionBarChange()
    {
         $oSession = new Session();
         $oSession['BarChange']=1;
    }
    public function actionRemoveSession($id)
    {
        $oSession = new Session();
        $oSession->remove($id);
    }
    public function actionGetChoosenSize()

    {
        $zmienna = 'dupa';
        
    }
    

}
