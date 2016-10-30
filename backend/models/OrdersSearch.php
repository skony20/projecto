<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersSearch represents the model behind the search form about `app\models\Orders`.
 */
class OrdersSearch extends Orders
{
    public $fullName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_deleted', 'customers_id', 'languages_id', 'order_date', 'orders_status_id', 'customer_ip', 'shippings_payments_id', 'shippings_couriers_id', 'shippings_vat_rate', 'realization_date', 'paid_date', 'send_date', 'creation_date', 'modification_date', 'is_giodo'], 'integer'],
            [['order_code', 'shippings_netto', 'shippings_brutto', 'value_netto', 'value_vat', 'value_brutto'], 'number'],
            [['customer_phone', 'customer_email', 'delivery_name', 'delivery_lastname', 'delivery_firm_name', 'delivery_street_local', 'delivery_zip', 'delivery_city', 'delivery_country', 'delivery_nip', 'invoice_name', 'invoice_lastname', 'invoice_firm_name', 'invoice_street_local', 'invoice_zip', 'invoice_city', 'invoice_country', 'invoice_nip', 'comments', 'shippings_vat', 'shippings_name'], 'safe'],
            [['fullName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Orders::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $dataProvider->setSort([
        'attributes' => [
            'id',     
            'order_date',
            'orders_status_id',
            'shippings_payments_id',
            'value_brutto',
            'customer_email',
            'fullName' => [
                'asc' => ['delivery_name' => SORT_ASC, 'delivery_lastname' => SORT_ASC],
                'desc' => ['delivery_name' => SORT_DESC, 'delivery_lastname' => SORT_DESC],
                'label' => 'Klient',
                'default' => SORT_ASC
            ],
        ],
        'defaultOrder' => ['id'=>SORT_DESC],    
    ]);
        
        $this->load($params);

        if (!($this->load($params) && $this->validate())) 
        {
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_deleted' => $this->is_deleted,
            'customers_id' => $this->customers_id,
            'languages_id' => $this->languages_id,
            'order_date' => $this->order_date,
            'order_code' => $this->order_code,
            'orders_status_id' => $this->orders_status_id,
            'customer_ip' => $this->customer_ip,
            'shippings_payments_id' => $this->shippings_payments_id,
            'shippings_couriers_id' => $this->shippings_couriers_id,
            'shippings_netto' => $this->shippings_netto,
            'shippings_vat_rate' => $this->shippings_vat_rate,
            'shippings_brutto' => $this->shippings_brutto,
            'value_netto' => $this->value_netto,
            'value_vat' => $this->value_vat,
            'value_brutto' => $this->value_brutto,
            'realization_date' => $this->realization_date,
            'paid_date' => $this->paid_date,
            'send_date' => $this->send_date,
            'creation_date' => $this->creation_date,
            'modification_date' => $this->modification_date,
            'is_giodo' => $this->is_giodo,
        ]);

        $query->andFilterWhere(['like', 'customer_phone', $this->customer_phone])
            ->andFilterWhere(['like', 'customer_email', $this->customer_email])
            ->andFilterWhere(['like', 'delivery_name', $this->delivery_name])
            ->andFilterWhere(['like', 'delivery_lastname', $this->delivery_lastname])
            ->andFilterWhere(['like', 'delivery_firm_name', $this->delivery_firm_name])
            ->andFilterWhere(['like', 'delivery_street_local', $this->delivery_street_local])
            ->andFilterWhere(['like', 'delivery_zip', $this->delivery_zip])
            ->andFilterWhere(['like', 'delivery_city', $this->delivery_city])
            ->andFilterWhere(['like', 'delivery_country', $this->delivery_country])
            ->andFilterWhere(['like', 'delivery_nip', $this->delivery_nip])
            ->andFilterWhere(['like', 'invoice_name', $this->invoice_name])
            ->andFilterWhere(['like', 'invoice_lastname', $this->invoice_lastname])
            ->andFilterWhere(['like', 'invoice_firm_name', $this->invoice_firm_name])
            ->andFilterWhere(['like', 'invoice_street_local', $this->invoice_street_local])
            ->andFilterWhere(['like', 'invoice_zip', $this->invoice_zip])
            ->andFilterWhere(['like', 'invoice_city', $this->invoice_city])
            ->andFilterWhere(['like', 'invoice_country', $this->invoice_country])
            ->andFilterWhere(['like', 'invoice_nip', $this->invoice_nip])
            ->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['like', 'shippings_vat', $this->shippings_vat])
            ->andFilterWhere(['like', 'shippings_name', $this->shippings_name]);
        

        $query->andWhere('delivery_name LIKE "%' . $this->fullName . '%" ' .
        'OR delivery_lastname LIKE "%' . $this->fullName . '%"'
    );
        return $dataProvider;
    }
}
