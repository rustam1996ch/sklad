<?php


namespace sklad\models\search;

use sklad\models\Client;
use sklad\models\Payment;
use sklad\models\Product;
use sklad\models\ProductType;
use sklad\models\Rasxod;
use sklad\models\Receipt;

use sklad\models\Sell;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;

class DebtSearch extends Model
{
    public $client_name;
    public $date;
    public $date1;
    public $date2;

    public function rules()
    {
        return [
            [['date', 'client_name','date1','date2'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /* Creates data provider instance with search query applied
    *
    * @param array $params
    *
    * @return ActiveDataProvider
    */
    public function search($params)
    {
        $this->load($params);

        $query = Sell::find();

        $subQueryClient = Client::find();
        $subQueryClient->select(new \yii\db\Expression('name'));
        $subQueryClient->where('sell.client_id = client.id');
//        $subQueryRasxodAmount->andFilterWhere(['between', 'rasxod.date', $this->date1, $this->date2]);
        $sqlClientName = $subQueryClient->createCommand()->getRawSql();

        $subQueryRasxod = Rasxod::find();
        $subQueryRasxod->select(new \yii\db\Expression('sum(rasxod.cost * rasxod.amount)'));
        $subQueryRasxod->where('rasxod.sell_id = sell.id');
//        $subQueryRasxod->andFilterWhere(['between', 'rasxod.date', $this->date1, $this->date2]);
        $subQueryRasxod->groupBy(['rasxod.sell_id']);
        $sqlRasxodSum = $subQueryRasxod->createCommand()->getRawSql();

        $subQueryPayment = Payment::find();
        $subQueryPayment->select(new \yii\db\Expression('sum(payment.amount)'));
        $subQueryPayment->where('payment.client_id = sell.client_id');
//        $subQueryPayment->andFilterWhere(['between', 'rasxod.date', $this->date1, $this->date2]);
        $subQueryPayment->groupBy(['payment.client_id']);
        $sqlPaymentSum = $subQueryPayment->createCommand()->getRawSql();

        $query->select([
            new \yii\db\Expression("
                (
                IFNULL(({$sqlClientName}), 0)
                ) as client_name
                "),
            new \yii\db\Expression("
                (
                IFNULL(({$sqlRasxodSum}), 0)
                ) as rasxod_sum
                "),
            new \yii\db\Expression("
                (
                IFNULL(({$sqlPaymentSum}), 0)
                ) as payment_sum
                "),
            new \yii\db\Expression('
                (
                (select rasxod_sum) - (select payment_sum)
                ) as debt
                '),
            'sell.car_number',
        ]);

        $query->joinWith('client')->andFilterWhere(['like', 'client.name', $this->client_name]);


        $sql = $query->createCommand()->getRawSql();
//        prd(Yii::$app->db->createCommand($sql)->queryAll());

        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $sql,
            'pagination' => FALSE,
        ]);
        return $dataProvider;
    }

}
