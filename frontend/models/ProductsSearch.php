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
    public $filters_id;
    public function rules()
    {
        return [
            [['id', 'is_active', 'sort_order', 'producers_id', 'vats_id', 'stock', 'rating_value', 'rating_votes', 'creation_date', 'modification_date', 'is_archive', 'sell_items'], 'integer'],
            [['pkwiu', 'symbol', 'ean', 'image', 'filters_id'], 'safe'],
            [['price_brutto_source', 'price_brutto'], 'number'],
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

        // add conditions that should always apply here
        $query->joinWith(['productsFilters']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'producers_id' => $this->producers_id,
            'vats_id' => $this->vats_id,
            'price_brutto_source' => $this->price_brutto_source,
            'price_brutto' => $this->price_brutto,
            'stock' => $this->stock,
            'rating_value' => $this->rating_value,
            'rating_votes' => $this->rating_votes,
            'creation_date' => $this->creation_date,
            'modification_date' => $this->modification_date,
            'is_archive' => $this->is_archive,
            'sell_items' => $this->sell_items,
            
        ]);
        $query->andFilterWhere(['in', 'products_filters.filters_id', $this->filters_id]);
        
        
        
        $query->andFilterWhere(['like', 'pkwiu', $this->pkwiu])
            ->andFilterWhere(['like', 'symbol', $this->symbol])
            ->andFilterWhere(['like', 'ean', $this->ean])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
