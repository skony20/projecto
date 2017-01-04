<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storeys".
 *
 * @property integer $id
 * @property integer $products_id
 * @property integer $storey_type
 * @property integer $storey_number
 * @property string $storey_name
 * @property string $room_name
 * @property string $room_area
 * @property string $room_area_netto
 * @property integer $sum
 *
 * @property Products $products
 */
class Storeys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'storeys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['products_id'], 'required'],
            [['products_id', 'storey_type', 'storey_number', 'sum', 'room_number'], 'integer'],
            [['room_area', 'room_area_netto'], 'number'],
            [['storey_name'], 'string', 'max' => 80],
            [['room_name'], 'string', 'max' => 90],
            [['products_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['products_id' => 'id']],
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
            'storey_type' => 'Storey Type',
            'storey_number' => 'Storey Number',
            'storey_name' => 'Storey Name',
            'room_name' => 'Room Name',
            'room_area' => 'Room Area',
            'room_area_netto' => 'Room Area Netto',
            'sum' => 'Sum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasOne(Products::className(), ['id' => 'products_id']);
    }
}
