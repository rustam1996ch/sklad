<?php

namespace sklad\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use sklad\models\ProductType;

/**
 * ProductTypeSearch represents the model behind the search form about `sklad\models\ProductType`.
 */
class ProductTypeSearch extends ProductType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'no', 'client_id'], 'integer'],
            [['name'], 'safe'],
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
        $query = ProductType::find()->orderBy(['id' => SORT_DESC]);

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

        $query->andFilterWhere([
            'client_id' => $this->client_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'parent', $this->parent])
            ->andFilterWhere(['like', 'no', $this->no]);

        return $dataProvider;
    }
}
