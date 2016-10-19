<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property string $id
 * @property integer $is_deleted
 * @property string $customers_id
 * @property integer $languages_id
 * @property string $order_date
 * @property double $order_code
 * @property integer $orders_status_id
 * @property string $customer_ip
 * @property string $customer_phone
 * @property string $customer_email
 * @property string $delivery_name
 * @property string $delivery_lastname
 * @property string $delivery_firm_name
 * @property string $delivery_street_local
 * @property string $delivery_zip
 * @property string $delivery_city
 * @property string $delivery_country
 * @property string $delivery_nip
 * @property string $invoice_name
 * @property string $invoice_lastname
 * @property string $invoice_firm_name
 * @property string $invoice_street_local
 * @property string $invoice_zip
 * @property string $invoice_city
 * @property string $invoice_country
 * @property string $invoice_nip
 * @property string $comments
 * @property string $shippings_payments_id
 * @property string $shippings_couriers_id
 * @property string $shippings_netto
 * @property string $shippings_vat
 * @property integer $shippings_vat_rate
 * @property string $shippings_brutto
 * @property string $shippings_name
 * @property string $value_netto
 * @property string $value_vat
 * @property string $value_brutto
 * @property integer $realization_date
 * @property integer $paid_date
 * @property integer $send_date
 * @property integer $creation_date
 * @property integer $modification_date
 *
 * @property OrdersPosition[] $ordersPositions
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_deleted', 'customers_id', 'languages_id', 'order_date', 'orders_status_id', 'customer_ip', 'shippings_payments_id', 'shippings_couriers_id', 'shippings_vat_rate', 'realization_date', 'paid_date', 'send_date', 'creation_date', 'modification_date'], 'integer'],
            [['order_date', 'order_code', 'customer_phone', 'customer_email', 'delivery_name', 'delivery_lastname', 'delivery_firm_name', 'delivery_street_local', 'delivery_zip', 'delivery_city', 'delivery_country', 'delivery_nip', 'invoice_name', 'invoice_lastname', 'invoice_firm_name', 'invoice_street_local', 'invoice_zip', 'invoice_city', 'invoice_country', 'invoice_nip', 'comments', 'shippings_couriers_id', 'shippings_vat', 'shippings_name'], 'required'],
            [['order_code', 'shippings_netto', 'shippings_brutto', 'value_netto', 'value_vat', 'value_brutto'], 'number'],
            [['comments', 'shippings_name'], 'string'],
            [['customer_phone'], 'string', 'max' => 25],
            [['customer_email', 'delivery_country', 'invoice_country'], 'string', 'max' => 100],
            [['delivery_name', 'delivery_lastname', 'delivery_firm_name', 'delivery_street_local', 'delivery_city', 'invoice_name', 'invoice_lastname', 'invoice_firm_name', 'invoice_street_local', 'invoice_city'], 'string', 'max' => 255],
            [['delivery_zip', 'invoice_zip'], 'string', 'max' => 10],
            [['delivery_nip', 'invoice_nip'], 'string', 'max' => 14],
            [['shippings_vat'], 'string', 'max' => 15],
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
            'customers_id' => 'Customers ID',
            'languages_id' => 'Languages ID',
            'order_date' => 'Order Date',
            'order_code' => 'Order Code',
            'orders_status_id' => 'Orders Status ID',
            'customer_ip' => 'Customer Ip',
            'customer_phone' => 'Customer Phone',
            'customer_email' => 'Customer Email',
            'delivery_name' => 'Delivery Name',
            'delivery_lastname' => 'Delivery Lastname',
            'delivery_firm_name' => 'Delivery Firm Name',
            'delivery_street_local' => 'Delivery Street Local',
            'delivery_zip' => 'Delivery Zip',
            'delivery_city' => 'Delivery City',
            'delivery_country' => 'Delivery Country',
            'delivery_nip' => 'Delivery Nip',
            'invoice_name' => 'Invoice Name',
            'invoice_lastname' => 'Invoice Lastname',
            'invoice_firm_name' => 'Invoice Firm Name',
            'invoice_street_local' => 'Invoice Street Local',
            'invoice_zip' => 'Invoice Zip',
            'invoice_city' => 'Invoice City',
            'invoice_country' => 'Invoice Country',
            'invoice_nip' => 'Invoice Nip',
            'comments' => 'Comments',
            'shippings_payments_id' => 'Shippings Payments ID',
            'shippings_couriers_id' => 'Shippings Couriers ID',
            'shippings_netto' => 'Shippings Netto',
            'shippings_vat' => 'Shippings Vat',
            'shippings_vat_rate' => 'Shippings Vat Rate',
            'shippings_brutto' => 'Shippings Brutto',
            'shippings_name' => 'Shippings Name',
            'value_netto' => 'Value Netto',
            'value_vat' => 'Value Vat',
            'value_brutto' => 'Value Brutto',
            'realization_date' => 'Realization Date',
            'paid_date' => 'Paid Date',
            'send_date' => 'Send Date',
            'creation_date' => 'Creation Date',
            'modification_date' => 'Modification Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersPositions()
    {
        return $this->hasMany(OrdersPosition::className(), ['orders_id' => 'id']);
    }
}
