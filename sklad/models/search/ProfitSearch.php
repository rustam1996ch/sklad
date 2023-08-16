<?php


namespace sklad\models\search;

use sklad\models\Product;
use sklad\models\ProductType;
use sklad\models\Rasxod;
use sklad\models\Receipt;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;

class ProfitSearch extends Model
{
    public $name;
    public $date;
//    public $date1;
//    public $date2;

    public function rules()
    {
        return [
            [['date', 'name'], 'safe'],
//            [['date', 'name','date1','date2'], 'safe'],
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

        $query = Product::find();

        $subQueryReceipt = Receipt::find();
        $subQueryReceipt->select(new \yii\db\Expression('AVG(receipt.cost)'));
        $subQueryReceipt->where('receipt.product_id = product.id');
        $subQueryReceipt->groupBy(['receipt.product_id']);
        $sqlReceiptAvgCost = $subQueryReceipt->createCommand()->getRawSql();

        $subQueryRasxod = Rasxod::find();
        $subQueryRasxod->select(new \yii\db\Expression('AVG(rasxod.cost)'));
        $subQueryRasxod->where('rasxod.product_id = product.id');
        $subQueryRasxod->groupBy(['rasxod.product_id']);
        $sqlRasxodAvgCost = $subQueryRasxod->createCommand()->getRawSql();

        $subQueryRasxodAmount = Rasxod::find();
        $subQueryRasxodAmount->select(new \yii\db\Expression('amount'));
        $subQueryRasxodAmount->where('rasxod.product_id = product.id');
        $sqlRasxodAmount = $subQueryRasxodAmount->createCommand()->getRawSql();

        $query->select([
            new \yii\db\Expression("
                (
                IFNULL(({$sqlReceiptAvgCost} ),0)
                ) as receiptAvg
                "),
            new \yii\db\Expression("
                (
                IFNULL(({$sqlRasxodAvgCost}), 0)
                ) as rasxodAvg
                "),
            new \yii\db\Expression("
                (
                IFNULL(({$sqlRasxodAmount}), 0)
                ) as rasxodAmount
                "),
            new \yii\db\Expression('
                (
                ((select rasxodAvg) - (select receiptAvg)) * (select rasxodAmount)
                ) as foyda
                '),
            'product.id',
            'product.name',
        ]);

        $query->andFilterWhere(['like', 'product.name', $this->name]);

        $sql = $query->createCommand()->getRawSql();
//        prd(Yii::$app->db->createCommand($sql)->queryAll());

        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $sql,
            'pagination' => FALSE,
        ]);
        return $dataProvider;
    }

}