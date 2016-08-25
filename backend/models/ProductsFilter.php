<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_filter".
 *
 * @property integer $products_id
 * @property integer $filters_id
 */
class ProductsFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['products_id', 'filters_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'products_id' => Yii::t('app', 'Products ID'),
            'filters_id' => Yii::t('app', 'Filters ID'),
        ];
    }
}
