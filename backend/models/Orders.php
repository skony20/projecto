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
 * @property integer $is_giodo
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
            [['is_deleted', 'customers_id', 'languages_id', 'order_date', 'orders_status_id', 'customer_ip', 'shippings_payments_id', 'shippings_couriers_id', 'shippings_vat_rate', 'realization_date', 'paid_date', 'send_date', 'creation_date', 'modification_date', 'is_giodo', 'is_invoice'], 'integer'],
            [['order_date', 'customer_phone', 'customer_email', 'delivery_name', 'delivery_lastname', 'delivery_firm_name', 'delivery_street_local', 'delivery_zip', 'delivery_city', 'delivery_country'], 'required'],
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
            'id' => Yii::t('app', 'Numer zamówienia'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'customers_id' => Yii::t('app', 'Klient'),
            'languages_id' => Yii::t('app', 'Languages ID'),
            'order_date' => Yii::t('app', 'Data zamówienia'),
            'order_code' => Yii::t('app', 'Kod zamówienia'),
            'orders_status_id' => Yii::t('app', 'Status'),
            'customer_ip' => Yii::t('app', 'Ip'),
            'customer_phone' => Yii::t('app', 'Numer telefonu'),
            'customer_email' => Yii::t('app', 'Adres e-mail'),
            'delivery_name' => Yii::t('app', 'Imię'),
            'delivery_lastname' => Yii::t('app', 'Nazwisko'),
            'delivery_firm_name' => Yii::t('app', 'Nazwa firmy'),
            'delivery_street_local' => Yii::t('app', 'Adress'),
            'delivery_zip' => Yii::t('app', 'Kod pocztowy'),
            'delivery_city' => Yii::t('app', 'Miasto'),
            'delivery_country' => Yii::t('app', 'Państwo'),
            'delivery_nip' => Yii::t('app', 'Numer NIP'),
            'is_invoice' => Yii::t('app', 'Faktura ?'),
            'invoice_name' => Yii::t('app', 'Imię'),
            'invoice_lastname' => Yii::t('app', 'Nazwisko'),
            'invoice_firm_name' => Yii::t('app', 'Nazwa formy'),
            'invoice_street_local' => Yii::t('app', 'Adress'),
            'invoice_zip' => Yii::t('app', 'Kod pocztowy'),
            'invoice_city' => Yii::t('app', 'Miasto'),
            'invoice_country' => Yii::t('app', 'Państwo'),
            'invoice_nip' => Yii::t('app', 'Numer NIP'),
            'comments' => Yii::t('app', 'Komantarz'),
            'shippings_payments_id' => Yii::t('app', 'Płatność'),
            'shippings_couriers_id' => Yii::t('app', 'Shippings Couriers ID'),
            'shippings_netto' => Yii::t('app', 'Shippings Netto'),
            'shippings_vat' => Yii::t('app', 'Shippings Vat'),
            'shippings_vat_rate' => Yii::t('app', 'Shippings Vat Rate'),
            'shippings_brutto' => Yii::t('app', 'Shippings Brutto'),
            'shippings_name' => Yii::t('app', 'Shippings Name'),
            'value_netto' => Yii::t('app', 'Value Netto'),
            'value_vat' => Yii::t('app', 'Value Vat'),
            'value_brutto' => Yii::t('app', 'Wartość'),
            'realization_date' => Yii::t('app', 'Realization Date'),
            'paid_date' => Yii::t('app', 'Paid Date'),
            'send_date' => Yii::t('app', 'Send Date'),
            'creation_date' => Yii::t('app', 'Creation Date'),
            'modification_date' => Yii::t('app', 'Modification Date'),
            'is_giodo' => Yii::t('app', 'Is Giodo'),
            'fullName' => Yii::t('app', 'Klient')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersPositions()
    {
        return $this->hasMany(OrdersPosition::className(), ['orders_id' => 'id']);
    }
    
    public function getOrdersStatus()
    {
        return $this->hasOne(OrdersStatus::className(), ['id' => 'orders_status_id']);
    }
    public function getPayment()
    {
        return $this->hasOne(PaymentsMethod::className(), ['id' => 'shippings_payments_id']);
    }
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'customers_id']);
    }
    public function getFullName() 
    {
        return $this->delivery_name . ' ' . $this->delivery_lastname ;
    }
    
}