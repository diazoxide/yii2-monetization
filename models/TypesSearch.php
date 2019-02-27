<?php

namespace diazoxide\yii2monetization\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use diazoxide\yii2monetization\models\Monetization;

/**
 * MonetizationSearch represents the model behind the search form of `diazoxide\yii2monetization\models\Monetization`.
 */
class TypesSearch extends Types
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Types::find();

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


        $query->andFilterWhere(['like', 'note', $this->name]);

        return $dataProvider;
    }
}
