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
        $oSession['FiltersSession'] = [];
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

        $iMinX = floor($query->onCondition(['attributes_id'=>7])->min('value'));
        $iMaxX = ceil($query->onCondition(['attributes_id'=>7])->max('value'));
        $iMinY = floor($query->onCondition(['attributes_id'=>6])->min('value'));
        $iMaxY = ceil($query->onCondition(['attributes_id'=>6])->max('value'));
        
        
        $aDimensions['iAllMinX'] = $iMinX;
        $aDimensions['iAllMaxX'] = $iMaxX;
        $aDimensions['iAllMinY'] = $iMinY;
        $aDimensions['iAllMaxY'] = $iMaxY;
        
        //echo '<pre>'.print_r($aDimensions, true); die();
        
        
                
        $aPostData = Yii::$app->request->post();
 //       echo '<pre>'.print_r($aPostData, true); die();
//        $aPostData[7] =4;
//        $aPostData[3] =1;
//        $aPostData[5] =15;
//        $aPostData[6] =17;
        /* Chwilowa zmiana koncepcji na sesje
        if (isset($aPostData['slider_x']))
        {
            $aX = explode(';', $aPostData['slider_x']);
            $iPostMinX = $aX[0];
            $iPostMaxX = $aX[1];
        }
        else
        {
            $iPostMinX =$iMinX;
            $iPostMaxX =$iMaxX;
        }
        if (isset($aPostData['slider_y']))
        {
            $aY = explode(';', $aPostData['slider_y']);
            $iPostMinY = $aY[0];
            $iPostMaxY = $aY[1];  

        }
        else
        {
            $iPostMinY =$iMinY;
            $iPostMaxY =$iMaxY;
        }
            */
        
        //$iPostMinX = (isset($oSession['DataFromBar']) ? $oSession['DataFromBar'] : $iMinX);
        $iPostMinX = $iMinX;
        $iPostMaxX = $iMaxX;
        $iPostMinY = $iMinY;
        $iPostMaxY = $iMaxY;
        $DataFromBarX = $oSession->get('DataFromBarX');
        $DataFromBarY = $oSession->get('DataFromBarY');
        if (isset($DataFromBarX))
        {
            $iPostMinX = $DataFromBarX['iPostMinX'];
            $iPostMaxX = $DataFromBarX['iPostMaxX'];
        }
        else
        {
            
        }
        if (isset($DataFromBarY))
        {
            $iPostMinY = $DataFromBarY['iPostMinY'];
            $iPostMaxY = $DataFromBarY['iPostMaxY'];
        }
        //echo '<pre> 444'. print_r($DataFromBar, TRUE); die();
        if ($aPostData && count($aPostData)>3)
        {
            foreach ($aPostData  as $Filters)
            {
                if (is_numeric($Filters))
                {
                    $aFiltersData[] .= $Filters;
                }
            }
            
            $query->andFilterWhere(['IN', 'products_filters.filters_id',$aFiltersData])->groupBy('id')->having('COUNT(*)='.count($aFiltersData) );

        }

        $query->onCondition('products_attributes.id IN (SELECT products_attributes.id FROM products_attributes WHERE (((value BETWEEN '.$iPostMinX .' AND '.$iPostMaxX .' ) AND (attributes_id =7)) OR ((value BETWEEN '.$iPostMinY .' AND '.$iPostMaxY .' ) AND (attributes_id =6))) GROUP BY products_attributes.products_id HAVING COUNT(DISTINCT products_attributes.value)=2)');
       // echo '<pre>'.print_r($dataProvider, true); die();
        $sProjectCount = $dataProvider->count;
   
        $iOneMinX = floor($query->select('products_attributes.*')->onCondition(['attributes_id'=>7])->min('value'));
        $iOneMaxX = ceil($query->select('products_attributes.*')->onCondition(['attributes_id'=>7])->max('value'));
        $iOneMinY= floor($query->select('products_attributes.*')->onCondition(['attributes_id'=>6])->min('value'));
        $iOneMaxY = ceil($query->select('products_attributes.*')->onCondition(['attributes_id'=>6])->max('value'));


        

        $aDimensions['iOneMinX'] = ($iPostMinX > $iOneMinX ? $iPostMinX : $iOneMinX);
        $aDimensions['iOneMaxX'] = ($iPostMaxX < $iOneMaxX ? $iPostMaxX : $iOneMaxX);
        $aDimensions['iOneMinY'] = ($iPostMinY > $iOneMinY ? $iPostMinY : $iOneMinY);
        $aDimensions['iOneMaxY'] = ($iPostMaxY < $iOneMaxY ? $iPostMaxY : $iOneMaxY);
        

        
        $aFiltersGroup = $oFiltersGroup::find()->where(['is_active'=> 1])->orderBy('sort_order')->all();
        foreach ($aFiltersGroup as $_aFiltersGroup)
        {
            $aFilters = $oFilters::find()->where(['filters_group_id' => $_aFiltersGroup->id, 'is_active'=> 1])->all();
            $aData[$_aFiltersGroup->id] = ['question'=>$_aFiltersGroup, 'answer' => $aFilters];
        }
        //echo '<pre>'.print_r($dataProvider, true); die();
       
        $oSession['aDimensions'] = $aDimensions;
        $oSession['FiltersSession'] = $aFiltersData;
        
        return $this->render('index', ['model' => $model,'sProjectCount' => $sProjectCount, 'aFilters'=>$aData, 'aFiltersData' => $aFiltersData, 'dataProvider'=>$dataProvider, 'aDimensions'=> $aDimensions]);
    }
    public function actionProjekty()
    {
        $model = new ProductsSearch();
        $oSession = new Session();
        $FiltersSession = $oSession->get('FiltersSession');
        $aDimensions = $oSession->get('aDimensions');
        //echo 'Filter'.print_r($FiltersSession , TRUE).'<br>'; die();

        $oFiltersGroup = new FiltersGroup();
        $oFilters = new Filters();
        $aFiltersGroup = $oFiltersGroup::find()->where(['is_active'=> 1])->orderBy('sort_order')->all();

        foreach ($aFiltersGroup as $_aFiltersGroup)
        {
            $aFilters = $oFilters::find()->where(['filters_group_id' => $_aFiltersGroup->id, 'is_active'=> 1])->all();
            $aData[$_aFiltersGroup->id] = ['question'=>$_aFiltersGroup, 'answer' => $aFilters];
        }
        $query = $model::find();

        $query->joinWith(['productsDescriptons']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>['pageSize' => 20],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                    ]
                ]
            ]);

        if (Yii::$app->request->post() && count(Yii::$app->request->post())>=2)
        {
            $FiltersSession = '';
            foreach (Yii::$app->request->post() as $Filters)
            {
                if (is_numeric($Filters))
                {
                    $FiltersSession[] .= $Filters;
                }
            }
        }
        $aSession['FiltersSession'] = $FiltersSession;
        if ($FiltersSession)
        {
            $query->joinWith(['productsFilters']);
            $query->andFilterWhere(['IN', 'products_filters.filters_id',$aSession['FiltersSession']]);
            $query->groupBy('id');
            $query->having('COUNT(*)='.count($FiltersSession) );
        }

        if (Yii::$app->request->isAjax)
        {
            return $this->renderAjax('products', ['dataProvider'=>$dataProvider]);
        }
        else
        {
             return $this->render('projekty',['aChooseFilters'=>$FiltersSession, 'aFilters'=>$aData, 'dataProvider'=>$dataProvider, 'aDimensions'=>$aDimensions]);
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
        $oSession->setTimeout(1);
        $oSession['DataFromBar'.$id.''] = Yii::$app->request->post();
    }
    public function actionDeleteBar()
    {
        $oSession = new Session();
        $oSession->removeFlash('DataFromBarX');
        $oSession->removeFlash('DataFromBarY');
    }

}
