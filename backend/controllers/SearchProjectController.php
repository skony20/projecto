<?php

namespace backend\controllers;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\SearchProject;
use app\models\Filters;
use app\models\FiltersGroup;
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
        $aFiltersDataAll =[];
        $aFiltersDataCount = [];
        $aFiltersDataCountOrg = [];
        $iSearchCount = count($aSearchData);
        $iLastSearch = SearchProject::find()->limit(1)->orderBy(['id' => SORT_DESC])->one();
        $aFiltersData['all'] = $iSearchCount;
        $aFiltersData['last'] = $iLastSearch->creation_date;
        $a=1;
        foreach ($aSearchData as $aSearchRow)
        {
            $aFilterSearch = unserialize($aSearchRow->filters);
            if (count($aFilterSearch) >0 )
            {
                $aFiltersDataCount[$a] = $aFilterSearch ;
                $a++;
            }
            
        }
        $aFiltersDataCount = array_count_values(call_user_func_array('array_merge', $aFiltersDataCount));
        $aFilters = Filters::find()->leftJoin('filters_group', 'filters.filters_group_id=filters_group.id')->andWhere(['filters.is_active'=>1, 'filters_group.is_active'=>1])->all();
        foreach ($aFilters as $aFiltersRow)
        {
            $aFiltersDataCountOrg[$aFiltersRow->id] = (isset($aFiltersDataCount[$aFiltersRow->id]) ? $aFiltersDataCount[$aFiltersRow->id] : 0);
        }
        arsort($aFiltersDataCountOrg);
        $aFilterDataText = [];
        foreach  ($aFiltersDataCountOrg as $key=>$value)
        {
            $aFilter = Filters::findOne(['id'=>$key]);
            $sFiltersGroupName = FiltersGroup::getFilterGroupName($aFilter->filters_group_id);
            $aFilterDataText[$sFiltersGroupName][$aFilter->name]=$value;
        }
        $x=1;
        $aMaxAnswer= [];
        foreach ($aFiltersDataCountOrg as $aFiltersDataCountOrgKey =>$aFiltersDataCountOrgValue)
        {
            $aFilter = Filters::findOne(['id'=>$aFiltersDataCountOrgKey]);
            $sFilterName = $aFilter->name;
            $aMaxAnswer[$sFilterName]= $aFiltersDataCountOrgValue;
            if ($x>2)
            {
                break;
            }
            $x++;
        }
        return $this->render('index', [
                'aFilterDataText'=>$aFilterDataText,
                'aFiltersData'=>$aFiltersData,
                'aMaxAnswer' => $aMaxAnswer
        ]);
    }

}
