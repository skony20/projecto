<?php
namespace app\models;

use Yii;
use app\models\Filters;
use app\models\FiltersGroup;
use app\models\FiltersSearch;
use app\models\FiltersGroupSearch;

class FiltersToProducts extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'filters_group';
    }
    public function get()
    {
        $oFiltersGroup = new FiltersGroup();
        $oFilters = new Filters();
        $aFiltersGroup = $oFiltersGroup::find()->where(['is_active'=> 1])->all();
        foreach ($aFiltersGroup as $_aFiltersGroup)
        {
            $aFilters = $oFilters::find()->where(['filters_group_id' => $_aFiltersGroup->id, 'is_active'=> 1])->all();
            $aData[$_aFiltersGroup->id] = ['question'=>$_aFiltersGroup, 'answer' => $aFilters];
        }
        return $aData;

    }

}
