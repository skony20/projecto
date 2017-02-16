<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Filters;

/**
 * FiltersSearch represents the model behind the search form about `app\models\Filters`.
 */
class FiltersSearch extends Filters
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language_id', 'is_active', 'filters_group_id', 'sort_order'], 'integer'],
            [['name', 'description', 'nicename_link'], 'safe'],
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
        $query = Filters::find();

        // add conditions that should always apply here

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
            'language_id' => $this->language_id,
            'is_active' => $this->is_active,
            'filters_group_id' => $this->filters_group_id,
            'sort_order' => $this->sort_order,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'nicename_link', $this->nicename_link])
            ->andFilterWhere(['like', 'sort_oder', $this->nicename_link])
                ->orderBy(['is_active'=> SORT_DESC,'sort_order' => SORT_ASC]);

        return $dataProvider;
    }
}
