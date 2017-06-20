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
 * @property integer $image_type_id
 * @property integer $storey_type
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
            [['products_id', 'name', 'description', 'image_type_id'], 'required'],
            [['products_id', 'image_type_id', 'storey_type'], 'integer'],
            [['name', 'description'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'products_id' => 'Id',
            'name' => 'Nazwa',
            'description' => 'Opis',
            'image_type_id' => 'Typ zdjęcia',
            'storey_type' => 'Rodzaj piętra',
        ];
    }
}