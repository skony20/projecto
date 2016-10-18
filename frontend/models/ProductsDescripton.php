<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_descripton".
 *
 * @property integer $products_id
 * @property integer $languages_id
 * @property string $nicename_link
 * @property string $name
 * @property string $name_model
 * @property string $name_subname
 * @property string $html_description
 * @property string $html_description_short
 * @property string $keywords
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * @property Products $products
 * @property Languages $languages
 */
class ProductsDescripton extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_descripton';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['products_id', 'languages_id', 'nicename_link', 'name', 'html_description', 'html_description_short'], 'required'],
            [['products_id', 'languages_id'], 'integer'],
            [['html_description', 'html_description_short', 'meta_title', 'meta_description', 'meta_keywords'], 'string'],
            [['nicename_link'], 'string', 'max' => 75],
            [['name'], 'string', 'max' => 255],
            [['name_model', 'name_subname'], 'string', 'max' => 50],
            [['keywords'], 'string', 'max' => 150],
            [['nicename_link'], 'unique'],
            [['products_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['products_id' => 'id']],
            [['languages_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::className(), 'targetAttribute' => ['languages_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'products_id' => 'Products ID',
            'languages_id' => 'Languages ID',
            'nicename_link' => 'Nicename Link',
            'name' => 'Nazwa',
            'name_model' => 'Nazwa pogrubiona',
            'name_subname' => 'Nazwa dodatkowa',
            'html_description' => 'Opis',
            'html_description_short' => 'Krótki opis',
            'keywords' => 'Słowa kluczowe',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
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
    public function getLanguages()
    {
        return $this->hasOne(Languages::className(), ['id' => 'languages_id']);
    }
    public function validate($attributeNames = null, $clearErrors = true) {
        parent::validate($attributeNames, $clearErrors);
        return TRUE;
    }
}
