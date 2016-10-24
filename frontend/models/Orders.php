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
            [['is_deleted', 'customers_id', 'languages_id', 'order_date', 'orders_status_id', 'shippings_payments_id', 'shippings_couriers_id', 'shippings_vat_rate', 'realization_date', 'paid_date', 'send_date', 'creation_date', 'modification_date'], 'integer'],
            [['customer_phone', 'delivery_name', 'delivery_lastname', 'delivery_street_local', 'delivery_zip', 'delivery_city', 'delivery_country', 'shippings_payments_id'], 'required'],
            [['value_brutto'], 'number'],
            [['comments', 'shippings_name'], 'string'],
            [['customer_phone'], 'string', 'max' => 25],
            [['customer_email', 'delivery_country', 'invoice_country'], 'string', 'max' => 100],
            [['delivery_name', 'delivery_lastname', 'delivery_firm_name', 'delivery_street_local', 'delivery_city', 'invoice_name', 'invoice_lastname', 'invoice_firm_name', 'invoice_street_local', 'invoice_city'], 'string', 'max' => 255],
            [['delivery_zip', 'invoice_zip'], 'string', 'max' => 10],
            [['delivery_nip', 'invoice_nip'], 'string', 'max' => 14],
            [['shippings_vat'], 'string', 'max' => 15],
            ['is_giodo', 'required', 'requiredValue' => 1,  'message'=>'Musisz wyrazić zgode na przetwarzanie swoich danych']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'customer_phone' => 'Numer telefonu',
            'customer_email' => 'Adres email',
            'delivery_name' => 'Imię',
            'delivery_lastname' => 'Nazwisko',
            'delivery_street_local' => 'Adres',
            'delivery_zip' => 'Kod pocztowy',
            'delivery_city' => 'Miasto',
            'delivery_country' => 'Państwo',
            'invoice_name' => 'Imię',
            'invoice_lastname' => 'Nazwisko',
            'invoice_firm_name' => 'Nazwa firmy',
            'invoice_street_local' => 'Adres',
            'invoice_zip' => 'Kod pocztowy',
            'invoice_city' => 'Miasto',
            'invoice_country' => 'Państwo',
            'invoice_nip' => 'Numer Nip',
            'comments' => 'Komantarz',
            'shippings_payments_id' => 'Sposób płatności',
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
            'is_giodo' => 'Wyrażam zgodę na przetwarzanie moich danych osobowych w celu realizacji zamówień. Informujemy, że zgodnie z Ustawą z dnia 29.08.1997 r. każdy Klient ma prawo wglądu do swoich danych, ich poprawiania, zarządzania, zaprzestania przetwarzania oraz żądania ich usunięcia. Podanie danych jest dobrowolne, ale brak zgody uniemożliwia realizację.'
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
