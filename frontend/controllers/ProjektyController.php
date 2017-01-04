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
use app\models\SearchProject;


/**
 * Site controller
 */
class ProjektyController extends MetaController
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
        //echo '<pre>ss'. print_r(Yii::$app->session['aDimensions'], TRUE); die();
        $model = new ProductsSearch();
        //$aFiltersData = [];
        //$aDimensions = [];
        $aFiltersData =  Yii::$app->session->get('aFiltersSession');
        $aDimensions =  Yii::$app->session->get('aDimensions');
        $oProductsAttributes = new ProductsAttributes();
        $oProductsFilters = new ProductsFilters();
        $aPrdFilters = [];
        $aAttributes = [];
        $aPostData = [];
        //echo '<pre>'. print_r (Yii::$app->session->get('aDimensions') , TRUE);
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
        $iMinSize = floor($oProductsAttributes->find()->onCondition(['attributes_id'=>4])->min('(CAST(value AS DECIMAL (5,2)))'));
        $iMaxSize = ceil($oProductsAttributes->find()->onCondition(['attributes_id'=>4])->max('(CAST(value AS DECIMAL (5,2)))'));

        if(empty($aDimensions))
        {
           
        
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
            //echo '<pre>aa'. print_r($_SESSION, TRUE). '</pre>'; die();
            $iMaxX = $aDimensions['iMaxX'];
            $iMaxY = $aDimensions['iMaxY'];
            $iPostMinSize = $aDimensions['iOneMinSize'];
            $iPostMaxSize = $aDimensions['iOneMaxSize'];
        }
       // echo '<pre>'. print_r ($aDimensions , TRUE); die();  
        if (count(Yii::$app->request->get())>=1)
        {
            
            $aPostData = explode('/', Yii::$app->request->get('tag'));
            $sHouseSize =  Yii::$app->request->get('HouseSize');
            $aPostData['strona'] ='';
            $aPostData['SizeX'] =Yii::$app->request->get('SizeX');
            $aPostData['SizeY'] =Yii::$app->request->get('SizeY');
            //echo 'Post'.print_r($sHouseSize, TRUE).'<br>';die();
            /*Zmiana inputów z rozmiarami dzialki*/
            $iMaxX = (isset($aPostData['SizeX']) ? $aPostData['SizeX']: $aDimensions['iMaxX']);
            $iMaxY = (isset($aPostData['SizeY']) ? $aPostData['SizeY']: $aDimensions['iMaxY']);
            $aDimensions['iMaxX'] =$iMaxX ;
            $aDimensions['iMaxY'] =$iMaxY ;
            $aPostData['SizeX'] = [''];
            $aPostData['SizeY'] = [''];
            Yii::$app->session['aFiltersSession'] = $aPostData;
           // echo '<pre>'. print_r($aDimensions , TRUE); die();
            /*Zmiana paska wielkości domu*/
            
            
            
            
            if ($sHouseSize != '' && $bBarChange)
            {
                //echo print_r($sHouseSize, TRUE); die();
                $aAllSize = explode('-', $sHouseSize);
                $iPostMinSize = $aAllSize[0];
                $iPostMaxSize = $aAllSize[1];

            }
           // echo '<pre>'. print_r([$iPostMinSize, $iPostMaxSize], TRUE); die();
            
            
            
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
            
            $aFiltersPrdGroup = [];
            if (count($aFiltersData) >0)
            {
                foreach ($aFiltersData as $iFilterInPrd)
                {
                    $aFiltersGroupInPrd = $oFilters->findOne($iFilterInPrd);
                    //$aFiltersPrdGroup[$aFiltersGroupInPrd->filters_group_id] = []; 
                    $aFiltersPrdGroup[$aFiltersGroupInPrd->filters_group_id][] = $aFiltersGroupInPrd->id;

                }
                foreach ($aFiltersPrdGroup as $aGroupsKey=>$aGroupsValue)
                {

                    foreach ($aGroupsValue as $GroupKey=>$GroupValue)
                    {
                        $aFiltersGQuery = $oProductsFilters->find()->select('products_id')->andFilterWhere(['products_filters.filters_id'=>$GroupValue])->asArray()->all();
                        $aFiltrsFromGruop[$aGroupsKey][] = $aFiltersGQuery;
                    }


                }
                foreach ($aFiltrsFromGruop as $GroupKey=>$GroupValue)
                {

                   $aMergeGroup = call_user_func_array("array_merge", $GroupValue);
                   $aMergedFilters[$GroupKey] = $aMergeGroup;
                }
                $aUnigueId = [];
                if (count($aMergedFilters)>1)
                {
                    $aMergeId = call_user_func_array("array_merge", $aMergedFilters);
                    $aMergeIdOne = array_map('current', $aMergeId);

                    foreach (array_count_values($aMergeIdOne) as $iCountKey=>$iCountValue)
                    {
                        if ($iCountValue >= count($aMergedFilters))
                        {
                            $aPrdFilters[] .= $iCountKey;
                        }
                    }
                    //$aUnigueId = array_diff_assoc($aMergeIdOne, array_unique($aMergeIdOne));
                }
                else
                {
                    $aUnigueIdd = call_user_func_array('array_merge', $aMergedFilters);
                    $aPrdFilters = array_map('current', $aUnigueIdd);

                }
            }
        /*Dane techniczne*/
         //echo '<pre>'. print_r([$iPostMinSize, $iPostMaxSize], TRUE); die();  
        $aAttributesQuery = $oProductsAttributes->find()->select('products_id')->where('((value BETWEEN '.$iPostMinSize.' AND '.$iPostMaxSize.' ) AND (attributes_id = 4 ) OR ((value < '.$iMaxX.') AND (attributes_id =7)) OR ((value < '.$iMaxY.' ) AND (attributes_id =6))) GROUP BY products_id HAVING COUNT(DISTINCT value)=3');
        
        foreach ($aAttributesQuery->asArray()->all() as $aProdIdFromAttributes)
        {
            $aAttributes[] .= $aProdIdFromAttributes['products_id'];
        }
        $aPrdIdsAll = array_merge($aPrdFilters, $aAttributes);
        $aPrdIds = array_diff_assoc($aPrdIdsAll, array_unique($aPrdIdsAll));
        if (empty($aPrdFilters) && count(array_filter($aPostData)) <3 )
        {
            $aPrdIds = $aPrdIdsAll;
        }
        if (empty($aAttributes) && count(array_filter($aPostData)) <3 )
        {
            $aPrdIds = $aPrdIdsAll;
        }
        //echo count($aPrdFilters) .'<br>'. count($aAttributes) .'<br>'. count($aPrdIdsAll) .'<br>'. count($aPrdIds); die();
        
        
        
        
        
        /*Wyszukiwanie*/
        if ($szukaj != '')
        {
            //echo $szukaj; die();
            $aPrdIds = [];
            $aSearchQuery =  $model::find()->joinWith('productsDescriptons')->andFilterWhere(['or',['like', 'products.symbol', $szukaj],['like', 'products_descripton.name', $szukaj],['like', 'products_descripton.keywords', $szukaj]])->asArray()->all();
            foreach ($aSearchQuery as $aSearchProducts)
            {
                $aPrdIds[] .= $aSearchProducts['id'];
            }
            if (count ($aPrdIds) == 0)
            {
                $aPrdIds[0] = 1;
            }
            
        }
        $iOneMinSize = floor($oProductsAttributes->find()->andFilterWhere(['IN', 'products_id', $aPrdFilters])->andWhere('attributes_id = 4')->min('(CAST(value AS DECIMAL (5,2)))'));
        $iOneMaxSize = ceil($oProductsAttributes->find()->andFilterWhere(['IN', 'products_id', $aPrdFilters])->andWhere('attributes_id = 4')->max('(CAST(value AS DECIMAL (5,2)))'));
        if (!empty($aPrdFilters))
        {
            if ($aPrdFilters[0] == 1)
            {
            $iOneMinSize = floor($oProductsAttributes->find()->andWhere('attributes_id = 4')->min('(CAST(value AS DECIMAL (5,2)))'));
            $iOneMaxSize = ceil($oProductsAttributes->find()->andWhere('attributes_id = 4')->max('(CAST(value AS DECIMAL (5,2)))'));
            }

        }
       
        $aDimensions['iOneMinSize'] = ($bBarChange ? $iPostMinSize : $iOneMinSize);
        $aDimensions['iOneMaxSize'] = ($bBarChange ? $iPostMaxSize : $iOneMaxSize);
        

        if (count(array_filter($aPostData))>=3 && count($aPrdIds) == 0)
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
        
        //echo '<pre>'. print_r([$aPrdIds, count(array_filter($aPostData)) ], TRUE); die();    
        $query = $model::find()->FilterWhere(['IN', 'products.id', $aPrdIds]);
        //tylko włączone projekty   ->andFilterWhere(['is_active' => 1])

        if (count(array_filter($aPostData))<=3 && !$bBarChange && (empty($aPrdFilters) && empty($aAttributes)))
                {
            echo '<br> To tu';
                    $query = $model::find();
                }
        //echo '<pre>'. print_r ($query  , TRUE); die();
        $query->joinWith('producers');
        $query->joinWith('productsDescriptons');
        $query->orderBy($aSort);
        
        //echo '<pre>'. print_r(count(array_filter($aPostData)), TRUE); die();    
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>
                [
                    'pageSize' => 18,
                    'defaultPageSize'=>18, 
                    'pageParam' => 'strona', 
                    
                ],
            ]);

        //echo '<pre>'.print_r($aPrdIds, true); die();
        return $this->render('index',['aChooseFilters'=>$aFiltersData, 'aFilters'=>$aData, 'dataProvider'=>$dataProvider, 'aDimensions'=>$aDimensions, 'sort'=>$sort, 'sSearchC' => $szukaj]);
 



    }
    
    public function actionReset()
    {
        $oSession = Yii::$app->session;
        Yii::$app->session['aFiltersSession'] = [];
        Yii::$app->session['aDimensions'] = [];
        Yii::$app->session['BarChange'] = [];
        
        
        $oSession->remove('aDimensions');
        $oSession->remove('BarChange');
        $oSession->remove('aFiltersSession');
        

    }
    
    public function actionAddToSession($id)
    {
        Yii::$app->session[$id] = Yii::$app->request->post();
    }
    public function actionBarchange()
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