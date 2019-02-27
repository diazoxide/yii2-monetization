<?php

namespace diazoxide\yii2monetization\models;

use kartik\daterange\DateRangeBehavior;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use diazoxide\yii2monetization\models\Monetization;

/**
 * MonetizationSearch represents the model behind the search form of `diazoxide\yii2monetization\models\Monetization`.
 */
class ConversionSearch extends Conversion
{
    public $signDateStart;
    public $signDateEnd;
    public $signDateRange;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['monetization_id'], 'integer'],
            [['signDateRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['sign_date','ip'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'signDateRange',
                'dateStartAttribute' => 'signDateStart',
                'dateEndAttribute' => 'signDateEnd',
            ]
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
        $query = Conversion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'monetization_id' => $this->monetization_id,
        ]);

        $query->andFilterWhere([
            'ip' => $this->ip,
        ]);

        //$query->andFilterWhere(['between', 'sign_date',  $this->signDateStart, $this->signDateEnd]);
        if($this->signDateStart && $this->signDateEnd) {
            $query->andFilterWhere(['>=', 'sign_date', date("Y-m-d H:i:s", $this->signDateStart)])
                ->andFilterWhere(['<', 'sign_date', date("Y-m-d H:i:s", $this->signDateEnd)]);
        }
        return $dataProvider;
    }
}
