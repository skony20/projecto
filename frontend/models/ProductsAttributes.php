<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_attributes".
 *
 * @property integer $id
 * @property integer $products_id
 * @property integer $attributes_id
 * @property string $value
 *
 * @property Products $products
 * @property Attributes $attributes
 */
class ProductsAttributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['products_id', 'attributes_id', 'value'], 'required'],
            [['products_id', 'attributes_id'], 'integer'],
            [['value'], 'string', 'max' => 100],
            [['products_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['products_id' => 'id']],
            [['attributes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attributes::className(), 'targetAttribute' => ['attributes_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'products_id' => Yii::t('app', 'Products ID'),
            'attributes_id' => Yii::t('app', 'Attributes ID'),
            'value' => Yii::t('app', 'Value'),
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
//    public function getAttributes()
//    {
//        return $this->hasOne(Attributes::className(), ['id' => 'attributes_id']);
//    }
}
