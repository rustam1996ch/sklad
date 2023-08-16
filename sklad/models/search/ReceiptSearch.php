<?php

namespace sklad\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use sklad\models\Receipt;

/**
 * ReceiptSearch represents the model behind the search form about `sklad\models\Receipt`.
 */
class ReceiptSearch extends Receipt
{

    public $notConfirmed;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'amount', 'status', 'packet_id'], 'integer'],
            [['date'], 'safe'],
            [['cost'], 'number'],
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
        $query = Receipt::find();/*->orderBy(['id' => SORT_DESC]);*/

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        if ($this->notConfirmed) {
            $query->andWhere(['receipt.status' => 0]);

            if (user()->identity->role_id == 3) {
                $query->andWhere(['receipt.move_who' => 0]);

            } elseif (user()->identity->role_id == 4) {
                $query->andWhere(['receipt.move_who' => 1]);

            }
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'product_id' => $this->product_id,
            'amount' => $this->amount,
            'status' => $this->status,
            'cost' => $this->cost,
            'packet_id' => $this->packet_id,
        ]);

        return $dataProvider;
    }
}
