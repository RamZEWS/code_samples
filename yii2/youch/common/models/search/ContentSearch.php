<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Content;

/**
 * ContentSearch represents the model behind the search form about `common\models\Content`.
 */
class ContentSearch extends Content
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'is_free', 'status', 'city_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description', 'date_from', 'date_to', 'phone', 'site', 'file_base_url', 'file_url'], 'safe'],
            [['price_from', 'price_to', 'rating'], 'number'],
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
        $query = Content::find();

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
            'user_id' => $this->user_id,
            'price_from' => $this->price_from,
            'price_to' => $this->price_to,
            'is_free' => $this->is_free,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'status' => $this->status,
            'city_id' => $this->city_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'rating' => $this->rating,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'file_base_url', $this->file_base_url])
            ->andFilterWhere(['like', 'file_url', $this->file_url]);

        return $dataProvider;
    }
}
