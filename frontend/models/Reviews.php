<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property string $id
 * @property integer $is_active
 * @property integer $languages_id
 * @property integer $products_id
 * @property integer $customers_id
 * @property string $customer_ip
 * @property string $author
 * @property string $email
 * @property string $content
 * @property string $creation_date
 *
 * @property Languages $languages
 * @property Products $products
 * @property User $customers
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active', 'languages_id', 'products_id', 'customers_id', 'creation_date'], 'integer'],
            [['customer_ip', 'author', 'email', 'content', 'creation_date'], 'required'],
            [['content'], 'string'],
            [['author'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
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
            'is_active' => 'Is Active',
            'languages_id' => 'Languages ID',
            'products_id' => 'Products ID',
            'customers_id' => 'Customers ID',
            'customer_ip' => 'Customer Ip',
            'author' => 'Imię',
            'email' => 'Email',
            'content' => 'Opinia',
            'creation_date' => 'Creation Date',
        ];
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
        return $this->hasOne(Products::className(), ['id' => 'products_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasOne(User::className(), ['id' => 'customers_id']);
    }
}
