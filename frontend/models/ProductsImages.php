<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_images".
 *
 * @property integer $id
 * @property integer $products_id
 * @property string $name
 * @property string $description
 */
class ProductsImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['products_id', 'name'], 'required'],
            [['products_id'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 200],
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
            'name' => 'Name',
            'description' => 'Description',
        ];
    }
}
