<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Producers;

/**
 * ProducersSearch represents the model behind the search form about `app\models\Producers`.
 */
class ProducersSearch extends Producers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'languages_id'], 'integer'],
            [['name', 'logo', 'nicename', 'meta_decription'], 'safe'],
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
        $query = Producers::find();

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
            'languages_id' => $this->languages_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'nicename', $this->nicename])
            ->andFilterWhere(['like', 'meta_decription', $this->meta_decription]);

        return $dataProvider;
    }
}
