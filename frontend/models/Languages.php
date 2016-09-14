<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property integer $is_active
 * @property string $currencies_symbol
 * @property string $code
 * @property string $subdomain
 * @property string $name
 *
 * @property FiltersGroup[] $filtersGroups
 * @property Messages[] $messages
 * @property OrdersStatus[] $ordersStatuses
 * @property Producers[] $producers
 * @property ProductsDescripton[] $productsDescriptons
 * @property Products[] $products
 */
class Languages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'required'],
            [['is_active'], 'integer'],
            [['currencies_symbol', 'name'], 'string', 'max' => 45],
            [['code'], 'string', 'max' => 2],
            [['subdomain'], 'string', 'max' => 3],
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
            'currencies_symbol' => 'Currencies Symbol',
            'code' => 'Code',
            'subdomain' => 'Subdomain',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiltersGroups()
    {
        return $this->hasMany(FiltersGroup::className(), ['language_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['language_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersStatuses()
    {
        return $this->hasMany(OrdersStatus::className(), ['languages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducers()
    {
        return $this->hasMany(Producers::className(), ['languages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsDescriptons()
    {
        return $this->hasMany(ProductsDescripton::className(), ['languages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['id' => 'products_id'])->viaTable('products_descripton', ['languages_id' => 'id']);
    }
}
