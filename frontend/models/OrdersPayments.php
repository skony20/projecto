<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders_payments".
 *
 * @property string $id
 * @property string $orders_id
 * @property string $source
 * @property string $code
 * @property string $status
 * @property string $error
 * @property string $value
 * @property string $description
 * @property string $transfer_date
 * @property string $creation_time
 */
class OrdersPayments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orders_id', 'creation_time'], 'integer'],
            [['source'], 'string'],
            [['code', 'status', 'value', 'description', 'creation_time'], 'required'],
            [['value'], 'number'],
            [['code'], 'string', 'max' => 150],
            [['status', 'error'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['transfer_date'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orders_id' => 'Orders ID',
            'source' => 'Source',
            'code' => 'Code',
            'status' => 'Status',
            'error' => 'Error',
            'value' => 'Value',
            'description' => 'Description',
            'transfer_date' => 'Transfer Date',
            'creation_time' => 'Creation Time',
        ];
    }
}
