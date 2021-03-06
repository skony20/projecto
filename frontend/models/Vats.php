<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vats".
 *
 * @property integer $id
 * @property integer $is_active
 * @property integer $is_default
 * @property string $name
 * @property integer $value
 *
 * @property OrdersPosition[] $ordersPositions
 * @property Products[] $products
 */
class Vats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active', 'is_default', 'value'], 'integer'],
            [['name', 'value'], 'required'],
            [['name'], 'string', 'max' => 15],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'is_default' => 'Is Default',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersPositions()
    {
        return $this->hasMany(OrdersPosition::className(), ['vat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['vats_id' => 'id']);
    }
}
