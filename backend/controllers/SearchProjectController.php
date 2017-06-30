<?php

namespace backend\controllers;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\SearchProject;
use app\models\Filters;
class SearchProjectController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $aSearchData = SearchProject::find()->all();
        $aFiltersData = [];
        $aFiltersDataCount = [];
        $aFiltersDataCountOrg = [];
        $iSearchCount = count($aSearchData);
        $aFiltersData['all'] = $iSearchCount;
        $a=1;
        foreach ($aSearchData as $aSearchRow)
        {
            $aFilterSearch = unserialize($aSearchRow->filters);
            if (count($aFilterSearch) >0 )
            {
                $aFiltersData['item'][$a]['filters'] = $aFilterSearch ;
                $aFiltersDataCount[$a] = $aFilterSearch ;
                $aFiltersData['item'][$a]['data'] = $aSearchRow->creation_date;
                $aFiltersData['item'][$a]['user'] = $aSearchRow->users_id;
                $a++;
            }
            
        }
        $aFiltersDataCount = array_count_values(call_user_func_array('array_merge', $aFiltersDataCount));
        $aFilters = Filters::find()->leftJoin('filters_group', 'filters.filters_group_id=filters_group.id')->andWhere(['filters.is_active'=>1, 'filters_group.is_active'=>1])->all();
        foreach ($aFilters as $aFiltersRow)
        {
            $aFiltersDataCountOrg[$aFiltersRow->id] = (isset($aFiltersDataCount[$aFiltersRow->id]) ? $aFiltersDataCount[$aFiltersRow->id] : 0);
        }
        
        ksort($aFiltersDataCountOrg);
        $aFilterDataText = [];
        
        foreach  ($aFiltersDataCountOrg as $key=>$value)
        {
            $aFilter = Filters::findOne(['id'=>$key]);
            $aFilterDataText[$aFilter->name]=$value;
        }
        echo '<pre>'. print_r($aFilterDataText, TRUE); 
        die();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
