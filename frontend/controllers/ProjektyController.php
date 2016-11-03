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


/**
 * Site controller
 */
class ProjektyController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
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



public function actionIndex($sort = 'default', $szukaj = '')
    {
        
        $model = new ProductsSearch();
        $aFiltersData = [];
        $aFiltersData =  Yii::$app->session->get('aFiltersSession');
        $aDimensions =  Yii::$app->session->get('aDimensions');
        $oProductsAttributes = new ProductsAttributes();
        $oProductsFilters = new ProductsFilters();
        $aPrdFilters = [];
        $aAttributes = [];
        $aPostData = [];
        
        $oFiltersGroup = new FiltersGroup();
        $oFilters = new Filters();
        $aFiltersGroup = $oFiltersGroup::find()->where(['is_active'=> 1])->orderBy('sort_order')->all();

        foreach ($aFiltersGroup as $_aFiltersGroup)
        {
            $aFilters = $oFilters::find()->where(['filters_group_id' => $_aFiltersGroup->id, 'is_active'=> 1])->all();
            $aData[$_aFiltersGroup->id] = ['question'=>$_aFiltersGroup, 'answer' => $aFilters];
        }
        $query = $model::find();

        $query->joinWith(['productsFilters']);
        $query->joinWith(['productsAttributes']);

        $bBarChange =  Yii::$app->session->get('BarChange');
        if(!isset($aDimensions))
        {
            $iMinSize = floor($oProductsAttributes->find()->onCondition(['attributes_id'=>4])->min('(CAST(value AS DECIMAL (5,2)))'));
            $iMaxSize = ceil($oProductsAttributes->find()->onCondition(['attributes_id'=>4])->max('(CAST(value AS DECIMAL (5,2)))'));
        
            $iMaxX = ceil($oProductsAttributes->find()->onCondition(['attributes_id'=>7])->max('(CAST(value AS DECIMAL (5,2)))'));
            $iMaxY = ceil($oProductsAttributes->find()->onCondition(['attributes_id'=>6])->max('(CAST(value AS DECIMAL (5,2)))'));
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
        if (count(Yii::$app->request->get())>1)
        {

            $aPostData = Yii::$app->request->get();
            $aPostData['page'] ='';
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
            
            Yii::$app->session['aFiltersSession'] = $aFiltersData;
            Yii::$app->session['aDimensions'] = $aDimensions;
            
        }
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
        /*Dane techniczne*/
        $aAttributesQuery = $oProductsAttributes->find()->select('products_id')->where('((value BETWEEN '.$iPostMinSize.' AND '.$iPostMaxSize.' ) AND (attributes_id = 4 ) OR ((value < '.$iMaxX.') AND (attributes_id =7)) OR ((value < '.$iMaxY.' ) AND (attributes_id =6))) GROUP BY products_id HAVING COUNT(DISTINCT value)=3');
        
        foreach ($aAttributesQuery->asArray()->all() as $aProdIdFromAttributes)
        {
            $aAttributes[] .= $aProdIdFromAttributes['products_id'];
        }
        
        $aPrdIdsAll = array_merge($aPrdFilters, $aAttributes);
        $aPrdIdsNotSearch = array_diff_assoc($aPrdIdsAll, array_unique($aPrdIdsAll));
        
        //echo '<pre>'.print_r($aPrdIdsNotSearch , true); die();
        /*Wyszukiwanie*/
        if ($szukaj != '')
        {
            $aSearchPrjs = [];
            $aSearchQuery =  $model::find()->joinWith('productsDescriptons')->andFilterWhere(['or',['like', 'products.symbol', $szukaj],['like', 'products_descripton.name', $szukaj],['like', 'products_descripton.keywords', $szukaj]])->asArray()->all();
            foreach ($aSearchQuery as $aSearchProducts)
            {
                $aSearchPrjs[] .= $aSearchProducts['id'];
            }
            if (count($aPrdIdsNotSearch)>0 and count($aSearchPrjs)>0)
            {
                $aPrdIdsAllSearch = array_merge($aSearchPrjs, $aPrdIdsNotSearch);
                $aPrdIds = array_diff_assoc($aPrdIdsAllSearch, array_unique($aPrdIdsAllSearch));
                //echo '<pre>'. print_r($aPrdIds, TRUE); die();
            }
            else if (count($aPrdIdsNotSearch) == 0 and count($aSearchPrjs)== 0)
            {
                $aPrdIds[0] = 1;
            }
             else if (count($aPrdIdsNotSearch) == 0 and count($aSearchPrjs)> 0)
            {
                $aPrdIds = $aSearchPrjs;
            }
 
            
        }
        else
        {
            $aPrdIds = $aPrdIdsNotSearch;
        }
        
        
        
        
        $iOneMinSize = floor($oProductsAttributes->find()->andFilterWhere(['IN', 'products_id', $aPrdFilters])->andWhere('attributes_id = 4')->min('(CAST(value AS DECIMAL (5,2)))'));
        $iOneMaxSize = ceil($oProductsAttributes->find()->andFilterWhere(['IN', 'products_id', $aPrdFilters])->andWhere('attributes_id = 4')->max('(CAST(value AS DECIMAL (5,2)))'));
        
        
        $aDimensions['iOneMinSize'] = ($bBarChange ? $iPostMinSize : $iOneMinSize);
        $aDimensions['iOneMaxSize'] = ($bBarChange ? $iPostMaxSize : $iOneMaxSize);
//        echo '<pre>'. print_r([$bBarChange, $iPostMinSize, $iOneMinSize, $iPostMaxSize, $iOneMaxSize, $aDimensions['iOneMinSize'], $aDimensions['iOneMaxSize']], TRUE); die();
        if (count(array_filter($aPostData))>4 && count($aPrdIds) == 0)
                {
                    $aPrdIds[0] = 1;
                }
        
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
                
                
        $query = $model::find()->FilterWhere(['IN', 'products.id', $aPrdIds]);
        if (count(array_filter($aPostData))<=4 && count($aPrdIds) == 0)
                {
                    $query = $model::find();
                }
        $query->joinWith('producers');
        $query->joinWith('productsDescriptons');
        $query->orderBy($aSort);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>['pageSize' => 20],
            ]);
        
        return $this->render('index',['aChooseFilters'=>$aFiltersData, 'aFilters'=>$aData, 'dataProvider'=>$dataProvider, 'aDimensions'=>$aDimensions, 'sort'=>$sort]);
 



    }
    
    public function actionReset()
    {
        $aSession = new Session();
        $aSession->remove('aDimensions');
        $aSession->remove('BarChange');

    }
    
    public function actionAddToSession($id)
    {
        Yii::$app->session->setTimeout(7200);
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
    public function actionFilterChange($iQuestion, $iAnswer)
    {
        $aFilters =Yii::$app->session->get('aFiltersSession');
        $aFilters[$iQuestion] = $iAnswer;
        Yii::$app->session['aFiltersSession'] = $aFilters;
        return true;
    }
}