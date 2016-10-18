<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producers".
 *
 * @property integer $id
 * @property string $name
 * @property integer $languages_id
 * @property string $logo
 * @property string $nicename
 * @property string $meta_decription
 *
 * @property OrdersPosition[] $ordersPositions
 * @property Languages $languages
 * @property Products[] $products
 */
class Producers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['languages_id'], 'integer'],
            [['name', 'logo', 'nicename'], 'string', 'max' => 45],
            [['meta_decription'], 'string', 'max' => 255],
            [['languages_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::className(), 'targetAttribute' => ['languages_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'languages_id' => 'Languages ID',
            'logo' => 'Logo',
            'nicename' => 'Nicename',
            'meta_decription' => 'Meta Decription',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersPositions()
    {
        return $this->hasMany(OrdersPosition::className(), ['producers_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasOne(Languages::className(), ['id' => 'languages_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['producers_id' => 'id']);
    }
}
