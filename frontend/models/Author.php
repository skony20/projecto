<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property integer $id
 * @property integer $products_id
 * @property string $name
 *
 * @property Products $products
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['products_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 20],
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
            'products_id' => 'Projekt',
            'name' => 'Imię i nazwisko',
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
