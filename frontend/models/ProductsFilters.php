<?php

namespace app\models;

use Yii;
use app\models\Filters;
use app\models\FiltersGroup;

/**
 * This is the model class for table "products_filters".
 *
 * @property integer $id
 * @property integer $products_id
 * @property integer $filters_id
 *
 * @property Products $products
 * @property Filters $filters
 */
class ProductsFilters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_filters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['products_id', 'filters_id'], 'integer'],
            [['products_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['products_id' => 'id']],
            [['filters_id'], 'exist', 'skipOnError' => true, 'targetClass' => Filters::className(), 'targetAttribute' => ['filters_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'products_id' => 'Products ID',
            'filters_id' => 'Filters ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasOne(Products::className(), ['id' => 'products_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilters()
    {
        return $this->hasOne(Filters::className(), ['id' => 'filters_id']);
    }

    /**
     * @inheritdoc
     * @return ProductsFiltersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsFiltersQuery(get_called_class());
    }
}
