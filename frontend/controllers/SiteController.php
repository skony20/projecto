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
use app\models\ProductsAttributes;
use app\models\ProductsFilters;
use yii\web\Session;
use common\models\User;
use app\models\SearchProject;
use yii\web\Cookie;
use frontend\models\Account;


/**
 * Site controller
 */
class SiteController extends MetaController
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
                    [
                        'actions' => ['onas', 'kontakt', 'wprojekcie', 'regulamin', 'wspolpraca', 'cookie', 'accordion', 'politykaPrywatnosci', 'zwrot', 'robots'],
                        'allow' => true,
                        'roles' => ['*'],
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
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
        $GetCookies = Yii::$app->request->cookies;
        $SetCookies = Yii::$app->response->cookies;
        //echo print_r($GetCookies->getValue('accordion'), true); die();
        $accordion = ($GetCookies->getValue('accordion') !== NULL ? $GetCookies->getValue('accordion') : 1);
        $SetCookies->add(new \yii\web\Cookie([
            'name' => 'accordion',
            'value' => $accordion,
            'expire' => time() + 86400 * 365,
            ])); 
        $this->layout = 'firstsite';
        $model = new ProductsSearch();
        Yii::$app->session['aDimensions'] = [];
        Yii::$app->session['aFiltersSession'] = [];
        $oFiltersGroup = new FiltersGroup();
        $oFilters = new Filters();
        $aFiltersData = [];
        $aDimensions = [];
        
        $oProductsAttributes = new ProductsAttributes();
        $aAttributes =[];
        $oProductsFilters = new ProductsFilters();
        $aPrdFilters = [];
               
        $iMinSize = floor($oProductsAttributes->find()->leftJoin('products', 'products.id = products_attributes.products_id')->onCondition(['products_attributes.attributes_id'=>4, 'products.is_active'=>1])->min('(CAST(products_attributes.value AS DECIMAL (5,2)))'));
        $iMaxSize = ceil($oProductsAttributes->find()->leftJoin('products', 'products.id = products_attributes.products_id')->onCondition(['attributes_id'=>4, 'products.is_active'=>1])->max('(CAST(value AS DECIMAL (5,2)))'));
        $iMaxX = ceil($oProductsAttributes->find()->leftJoin('products', 'products.id = products_attributes.products_id')->onCondition(['attributes_id'=>7, 'products.is_active'=>1])->max('(CAST(value AS DECIMAL (5,2)))'));
        $iMaxY = ceil($oProductsAttributes->find()->leftJoin('products', 'products.id = products_attributes.products_id')->onCondition(['attributes_id'=>6, 'products.is_active'=>1])->max('(CAST(value AS DECIMAL (5,2)))'));
        //echo '<pre>'. print_r($oProductsAttributes->find()->where(['products.is_active'=>1])->all(), TRUE);
        
        $aDimensions['iAllMinSize'] = $iMinSize;
        $aDimensions['iAllMaxSize'] = $iMaxSize;
              
        $aPostData = Yii::$app->request->post();
        
        $iPostMinSize = $iMinSize ;
        $iPostMaxSize = $iMaxSize;
//        
//        $aPostData[0] =4;
//        $aPostData[1] =1;
        
        //echo '<pre>'.print_r($aPostData , true); die();
        $bBarChange = Yii::$app->session->get('BarChange');
        if (isset($aPostData['HouseSize']) && $bBarChange)
        {
            $aAllSize = explode('-', $aPostData['HouseSize']);
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
            //echo '<pre>PrdFilters: '. print_r($aFiltersData, true); die();
            if ($aFiltersData)
            {
                
                /*Odpowiedzi na pytania*/
                $aFiltersQuery = $oProductsFilters->find()->select('products_id')->andFilterWhere(['IN', 'products_filters.filters_id',$aFiltersData])->groupBy('products_id')->having('COUNT(*)='.count($aFiltersData))->asArray()->all();
                //echo print_r ($aFiltersQuery, TRUE); die();
                foreach ($aFiltersQuery as $aProdIdFromFilters)
                {
                    $aPrdFilters[] .= $aProdIdFromFilters['products_id'];
                }
                if (count($aFiltersQuery) == 0)
                {
                    $aPrdFilters[0] = 1;
                }
            
            }
        }
        
        /*Dane techniczne*/
        
        $aAttributesQuery = $oProductsAttributes->find()->select('products_id')->where('((value BETWEEN '.$iPostMinSize.' AND '.$iPostMaxSize.' ) AND (attributes_id = 4 ) OR ((value < '.$iMaxX.') AND (attributes_id =7)) OR ((value < '.$iMaxY.' ) AND (attributes_id =6))) GROUP BY products_id HAVING COUNT(value)=3');
        
        foreach ($aAttributesQuery->asArray()->all() as $aProdIdFromAttributes)
        {
            $aAttributes[] .= $aProdIdFromAttributes['products_id'];
        }
        
        $aPrdIdsAll = array_merge($aPrdFilters, $aAttributes);
        $aPrdIds = array_diff_assoc($aPrdIdsAll, array_unique($aPrdIdsAll));
        if (empty($aPrdFilters) && count(array_filter($aPostData)) <4 )
        {
            $aPrdIds = $aPrdIdsAll;
        }
        //echo '<pre>'.print_r($aPrdIds , true); die();
        $iOneMinSize = floor($oProductsAttributes->find()->andFilterWhere(['IN', 'products_id', $aPrdIds])->andWhere('attributes_id = 4')->min('(CAST(value AS DECIMAL (5,2)))'));
        $iOneMaxSize = ceil($oProductsAttributes->find()->andFilterWhere(['IN', 'products_id', $aPrdIds])->andWhere('attributes_id = 4')->max('(CAST(value AS DECIMAL (5,2)))'));
        
        
        $aDimensions['iOneMinSize'] = ($bBarChange ? $iPostMinSize : $iOneMinSize);
        $aDimensions['iOneMaxSize'] = ($bBarChange ? $iPostMaxSize : $iOneMaxSize);
        
       
        //echo '<br>Dimensions: '. print_r([$iPostMinSize, $iOneMinSize, $iPostMaxSize, $iOneMaxSize], true); die();
        
        if (count($aPostData)>4 && count($aPrdIds) == 0)
                {
                    $aPrdIds[0] = 1;
                }
        //echo print_r([$aPostData,$aPrdIds], TRUE); die();
        $query = $model::find()->FilterWhere(['IN', 'id', $aPrdIds])->andFilterWhere(['is_active' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                    ]
                ]
            ]);
        
        $sProjectCount = $dataProvider->count;
        
        $aFiltersGroup = $oFiltersGroup::find()->where(['is_active'=> 1])->orderBy('sort_order')->all();
        foreach ($aFiltersGroup as $_aFiltersGroup)
        {
            $aFilters = $oFilters::find()->where(['filters_group_id' => $_aFiltersGroup->id, 'is_active'=> 1])->orderBy(['sort_order'=>SORT_ASC])->all();
            $aData[$_aFiltersGroup->id] = ['question'=>$_aFiltersGroup, 'answer' => $aFilters];
        }
        Yii::$app->session['aFiltersSession'] = $aFiltersData;
        Yii::$app->session['aDimensions'] = $aDimensions;
        
        
        
        //echo '<pre>'. print_r(Yii::$app->session['aDimensions'], TRUE). '</pre>'; die();
        return $this->render('index', ['sProjectCount' => $sProjectCount, 'aFilters'=>$aData, 'aFiltersData' => $aFiltersData, 'aDimensions'=> $aDimensions]);
    }
    
    /**/
    
    
    /**/
    
    
    
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionReset()
    {
        $aSession = new Session();
        $aSession->remove('aDimensions');
        $aSession->remove('BarChange');

    }
    public function actionLogin()
    {
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        Yii::$app->view->registerMetaTag([
        'name' => 'robots',
        'content' => 'follow, noindex'
        ], 'robots');
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
        Yii::$app->user->logout(false);

        return $this->goBack();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionKontakt()
    {
        $this->layout = 'staticpage';
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['supportEmail'])) {
                Yii::$app->session->setFlash('success', 'Dziękujemy za wiadomość, postaramy się odpowiedzieć tak szybko jak to możliwe.');
            } else {
                Yii::$app->session->setFlash('error', 'Nastąpił błąd podczas wysyłania. Spróbuj ponownie za chwilę.');
            }

            return $this->refresh();
        } else {
            return $this->render('kontakt', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionOnas()
    {

        return $this->render('onas');
    }
    public function actionWprojekcie()
    {

        return $this->render('wprojekcie');
    }
    public function actionRegulamin()
    {
        Yii::$app->view->registerMetaTag([
        'name' => 'robots',
        'content' => 'follow, noindex'
        ], 'robots');
        return $this->render('regulamin');
    }
    public function actionWspolpraca()
    {

        return $this->render('wspolpraca');
    }
    public function actionCookie()
    {
        Yii::$app->view->registerMetaTag([
        'name' => 'robots',
        'content' => 'follow, noindex'
        ], 'robots');
        return $this->render('cookie');
    }
    public function actionPolitykaPrywatnosci()
    {
        Yii::$app->view->registerMetaTag([
        'name' => 'robots',
        'content' => 'follow, noindex'
        ], 'robots');
        return $this->render('politykaPrywatnosci');
    }
    public function actionZwrot()
    {
        Yii::$app->view->registerMetaTag([
        'name' => 'robots',
        'content' => 'follow, noindex'
        ], 'robots');
        return $this->render('zwrot');
    }
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $model->username = Yii::$app->request->post('SignupForm')['email'];
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $model->sendEmail();
                if (Yii::$app->getUser()->login($user)) {

                    return $this->redirect('user/adress-data');
                }
            }
        }
        Yii::$app->view->registerMetaTag([
        'name' => 'robots',
        'content' => 'follow, noindex'
        ], 'robots');
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
                Yii::$app->session->setFlash('success', 'Sprawdź skrzynkę pocztową i postępuj według instrukcji');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Nie możemy wysłać linku dla takiego adresu');
            }
        }
        Yii::$app->view->registerMetaTag([
        'name' => 'robots',
        'content' => 'follow, noindex'
        ], 'robots');
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
        Yii::$app->view->registerMetaTag([
        'name' => 'robots',
        'content' => 'follow, noindex'
        ], 'robots');
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    public function actionAddToSession($id)
    {
        
        Yii::$app->session[$id] = Yii::$app->request->post();
    }
    public function actionBarChange()
    {
         Yii::$app->session['BarChange']=1;
    }
    public function actionRemoveSession($id)
    {
       
        Yii::$app->session->remove($id);
    }
    public function actionSaveFilters()
    {
        $aFiltersData = Yii::$app->session->get('aFiltersSession');
        $oSearchProjects = new SearchProject();
        $oSearchProjects->filters = serialize($aFiltersData);
        $oSearchProjects->users_id = (Yii::$app->user->isGuest ? NULL : Yii::$app->user->identity->id);
        $oSearchProjects->creation_date = time();
        $oSearchProjects->save();
    }
    
    
    public function oAuthSuccess($client) {
      //
    $userAttributes = $client->getUserAttributes();
   //echo '<pre>'.print_r($client->getUserAttributes(), TRUE); die();
    $oUser = User::findOne(['email'=> $userAttributes['email'], 'source'=>$client->name]);
    if ($oUser)
    {
        //echo '<pre>'. print_r($oUser, TRUE); die();
        Yii::$app->user->login($oUser, 3600 * 24 * 30);
    }
    else
    {
        $oUser = new User();
        $oUser->role = 10;
        $oUser->status = 10;
        switch($client->name)
        {
            case 'facebook':
                $oUser->username = $userAttributes['name'];
                $oUser->email = $userAttributes['email'];
                $oUser->delivery_name = $userAttributes['first_name'];
                $oUser->delivery_lastname = $userAttributes['last_name'];
                break;
            case 'google':
                $oUser->username = $userAttributes['displayName'];
                $oUser->email = $userAttributes['emails'][0]['value'];
                $oUser->delivery_name = $userAttributes['name']['givenName'];
                $oUser->delivery_lastname = $userAttributes['name']['familyName'];
        }
        
        
        $oUser->source = $client->name;
                
        if ($oUser->save(false))
        {
            $oNewUser = User::findOne(['email'=> $oUser->email, 'source'=>$client->name]);
            Yii::$app->user->login($oNewUser, 3600 * 24 * 30);
        }
        
    }
        
    //echo '<pre>'. print_r($_user, TRUE); die();
    //return Yii::$app->user->login($userAttributes['first_name'], 3600 * 24 * 30);

     }
     
     /*Cookie do kontrolowania accordion*/
     public function actionAccordion($iId)
     {
         
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'accordion',
            'value' => $iId,
            'expire' => time() + 86400 * 365,
            ])); 
     }
     /*robots.txt*/
     public function actionRobots()
     {
        $response = Yii::$app->response;
        $response->format = yii\web\Response::FORMAT_RAW;
        $response->headers->set('Content-Type', 'text/plain');
        return ($this->renderPartial('robots'));
     }
     
}
    


