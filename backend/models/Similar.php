<?php

namespace app\models;

use Yii;
use app\models\ProductsDescripton;

/**
 * This is the model class for table "similar".
 *
 * @property integer $main_product_id
 * @property integer $products_id
 *
 * @property Products $mainProduct
 */
class Similar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'similar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['main_product_id', 'products_id'], 'required'],
            [['main_product_id', 'products_id'], 'integer'],
            [['main_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['main_product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'main_product_id' => 'Main Product ID',
            'products_id' => 'Products ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'main_product_id']);
    }
    public function getSimilarByName($p_sName)
            
    {
        $aIds = [];
        $sName = ((string)($p_sName));
        $oProjects = new ProductsDescripton();
        $aProjects = $oProjects->find()->andWhere(['languages_id'=>1])->andFilterWhere( ['like','name',$sName])->all();
        foreach ($aProjects as $aProject)
        {
            $aIds[] = $aProject->products_id;
        }
        return $aIds;
        //echo '<pre>'. print_r($aIds, TRUE); die();
    }
    public function countSimilar($p_iMainId)
    {
        $iMainId = ((int)($p_iMainId));
        $oSimilar = new Similar();
        $iSimilar = $oSimilar->find()->where(['main_product_id'=>$iMainId])->count();
        return $iSimilar;
    }
    public function deleteSimilar($p_iMainId, $p_iSimilarId)
    {
        $iMainId = ((int)($p_iMainId));
        $iSimilarId = ((int)($p_iSimilarId));
        $oSimilar = new Similar();
        if ($oSimilar->deleteAll(['main_product_id'=>$iMainId, 'products_id'=>$iSimilarId]))
        {
            return TRUE;
        }
        
    }
            
}
