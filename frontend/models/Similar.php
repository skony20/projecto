<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "similar".
 *
 * @property integer $id
 * @property integer $main_product_id
 * @property integer $products_id
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
            [['main_product_id', 'products_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_product_id' => 'Produkt główny',
            'products_id' => 'Podobne',
        ];
    }
}
