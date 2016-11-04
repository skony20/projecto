<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;

/**
 * ProductsSearch represents the model behind the search form about `app\models\Products`.
 */
class ProductsSearch extends Products
{
    /**
     * @inheritdoc
     */
    public $prjName;
    public function rules()
    {
        return [
            [['id', 'is_active', 'sort_order', 'producers_id', 'vats_id', 'stock', 'rating_value', 'rating_votes', 'creation_date', 'modification_date', 'is_archive', 'sell_items'], 'integer'],
            [['symbol', 'ean', 'image'], 'safe'],
            [['price_brutto_source', 'price_brutto'], 'number'],
            [['prjName'], 'safe'],
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
        $query = Products::find();
        $query->joinWith('productsDescriptons');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
        'attributes' => [
            'id',     
            'is_active',
            'producers_id',
            'price_brutto_source',
            'symbol',
            'prjName' => [
                'asc' => ['products_descripton.name' => SORT_ASC],
                'desc' => ['products_descripton.name' => SORT_DESC],
                'label' => 'Nazwa',
                'default' => SORT_ASC
            ],
        ],
        'defaultOrder' => ['id'=>SORT_DESC],    
    ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        

        // grid filtering conditions
        $query->andFilterWhere([
            'products.id' => $this->id,
            'products.is_active' => $this->is_active,
            'products.producers_id' => $this->producers_id,
            'products.price_brutto_source' => $this->price_brutto_source,
        ]);

        $query->andFilterWhere(['like', 'products.symbol', $this->symbol]);
         $query->andWhere('products_descripton.name LIKE "%' . $this->prjName . '%" ' );

        return $dataProvider;
    }
}
