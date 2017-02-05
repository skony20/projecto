<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders_position".
 *
 * @property integer $id
 * @property integer $is_deleted
 * @property string $orders_id
 * @property integer $products_id
 * @property integer $producers_id
 * @property string $name
 * @property string $name_model
 * @property string $name_subname
 * @property string $symbol
 * @property string $vat_id
 * @property string $price_brutto_source
 * @property string $price_brutto
 * @property integer $quantity
 * @property string $value_netto
 * @property string $value_vat
 * @property string $value_brutto
 * @property integer $creation_date
 * @property integer $modification_date
 *
 * @property Orders $orders
 * @property Products $products
 * @property Producers $producers
 * @property Vats $vat
 */
class OrdersPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_deleted', 'orders_id', 'products_id', 'producers_id', 'vat_id', 'quantity', 'creation_date', 'modification_date'], 'integer'],
            [['orders_id', 'products_id', 'producers_id', 'name', 'symbol', 'vat_id', 'price_brutto_source', 'price_brutto', 'quantity', 'value_brutto', 'creation_date'], 'required'],
            [['name', 'name_subname'], 'string', 'max' => 255],
            [['name_model', 'symbol'], 'string', 'max' => 45],
            [['orders_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['orders_id' => 'id']],
            [['products_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['products_id' => 'id']],
            [['producers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producers::className(), 'targetAttribute' => ['producers_id' => 'id']],
            [['vat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vats::className(), 'targetAttribute' => ['vat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_deleted' => 'Is Deleted',
            'orders_id' => 'Orders ID',
            'products_id' => 'Products ID',
            'producers_id' => 'Producers ID',
            'name' => 'Name',
            'name_model' => 'Name Model',
            'name_subname' => 'Name Subname',
            'symbol' => 'Symbol',
            'vat_id' => 'Vat ID',
            'price_brutto_source' => 'Price Brutto Source',
            'price_brutto' => 'Price Brutto',
            'quantity' => 'Quantity',
            'value_netto' => 'Value Netto',
            'value_vat' => 'Value Vat',
            'value_brutto' => 'Value Brutto',
            'creation_date' => 'Creation Date',
            'modification_date' => 'Modification Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasOne(Orders::className(), ['id' => 'orders_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasOne(Products::className(), ['id' => 'products_id']);
    }
    public function getProductsDescriptions()
    {
        return $this->hasOne(ProductsDescripton::className(), ['products_id' => 'products_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducers()
    {
        return $this->hasOne(Producers::className(), ['id' => 'producers_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVat()
    {
        return $this->hasOne(Vats::className(), ['id' => 'vat_id']);
    }
}
