<?php

namespace sklad\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use sklad\models\Rasxod;

/**
 * RasxodSearch represents the model behind the search form about `sklad\models\Rasxod`.
 */
class RasxodSearch extends Rasxod
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'product_id', 'packet_id', 'sell_id'], 'integer'],
            [['date', 'amount', 'note'], 'safe'],
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
        $query = Rasxod::find();

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

        if($this->date){
            $dateBegin = preg_replace('/(\d{2}).(\d{2}).(\d{1,4}) - (\d{2}).(\d{2}).(\d{1,4})/', '$3-$2-$1', $this->date);
            $dateEnd = preg_replace('/(\d{2}).(\d{2}).(\d{1,4}) - (\d{2}).(\d{2}).(\d{1,4})/', '$6-$5-$4', $this->date);
            $query->andWhere("date >='{$dateBegin}'");
            $query->andWhere("date <='{$dateEnd}'");
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'cost' => $this->cost,
            'product_id' => $this->product_id,
            'packet_id' => $this->packet_id,
            'sell_id' => $this->sell_id,
        ]);

        $query->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
