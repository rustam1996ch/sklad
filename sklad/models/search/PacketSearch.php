<?php

namespace sklad\models\search;

use sklad\models\Packet;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PacketSearch represents the model behind the search form about `sklad\models\Packet`.
 */
class PacketSearch extends Packet
{
    public $dateRange;
    public $dateBegin;
    public $dateEnd;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'amount', 'status', 'left', 'space'], 'integer'],
            [['note', 'date', 'dateBegin', 'dateEnd', 'dateRange'], 'safe'],
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
        $query = Packet::find()->orderBy(['id' => SORT_DESC]);

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

        if ($this->date) {
            $dateBegin = preg_replace('/(\d{2}).(\d{2}).(\d{1,4}) - (\d{2}).(\d{2}).(\d{1,4})/', '$3-$2-$1', $this->date);
            $dateEnd = preg_replace('/(\d{2}).(\d{2}).(\d{1,4}) - (\d{2}).(\d{2}).(\d{1,4})/', '$6-$5-$4', $this->date);
            $query->andWhere("date >='{$dateBegin}'");
            $query->andWhere("date <='{$dateEnd}'");
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'amount' => $this->amount,
            'status' => $this->status,
            'left' => $this->left,
//            'date' => $this->date,
            'space' => $this->space,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
