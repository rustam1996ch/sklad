<?php

namespace sklad\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use sklad\models\Sell;

/**
 * SellSearch represents the model behind the search form about `sklad\models\Sell`.
 */
class SellSearch extends Sell
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'status','invoice_no','contract_no'], 'integer'],
            [['date', 'car_number', 'note','contract_date'], 'safe'],
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
        $query = Sell::find();/*->orderBy(['id' => SORT_DESC]);*/

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
        // if ($this->status == 0) {
        //     $query->where(['status' => 0]);
        // }

        if($this->date){
            $dateBegin = preg_replace('/(\d{2}).(\d{2}).(\d{1,4}) - (\d{2}).(\d{2}).(\d{1,4})/', '$3-$2-$1', $this->date);
            $dateEnd = preg_replace('/(\d{2}).(\d{2}).(\d{1,4}) - (\d{2}).(\d{2}).(\d{1,4})/', '$6-$5-$4', $this->date);
            $query->andWhere("date >='{$dateBegin}'");
            $query->andWhere("date <='{$dateEnd}'");
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'client_id' => $this->client_id,
            'status' => $this->status,
            'invoice_no'=>$this->invoice_no,
            'contract_no'=>$this->contract_no,
        ]);

        $query->andFilterWhere(['like', 'car_number', $this->car_number])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
