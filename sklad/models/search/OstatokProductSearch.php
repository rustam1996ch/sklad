<?php

namespace sklad\models\search;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;

use sklad\models\Product;
use sklad\models\ProductType;
use sklad\models\Rasxod;
use sklad\models\Receipt;
/**
 * AnalizSearch represents the model behind the search form of `app\models\Analiz`.
 */
class OstatokProductSearch extends Model
{

	public $name;
	public $date;
//	public $date1;
//	public $date2;
    public $mark;
    public $product_type_name;
	public function rules()
    {
        return [
            [['name'], 'string'],
            [['date','mark','product_type_name'], 'safe'],
        ];

    }
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
 		$array = [];
 		$this->load($params);

        $query = Product::find();

        $date = convert_date($this->date);

//        $subQueryReceipt = Receipt::find();
//        $subQueryReceipt ->select(new \yii\db\Expression('sum(receipt.amount)'));
//        $subQueryReceipt ->where('receipt.product_id = product.id');
//        $subQueryReceipt ->andFilterWhere(['<=', 'receipt.date', $date]);
//        $subReceipt = $subQueryReceipt->createCommand()->getRawSql();
//
//        $subQueryRasxod = Rasxod::find();
//        $subQueryRasxod ->select(new \yii\db\Expression('sum(rasxod.amount)'));
//        $subQueryRasxod ->where('rasxod.product_id = product.id');
//        $subQueryRasxod ->andFilterWhere(['<=', 'rasxod.date', $date]);
//        $subRasxod = $subQueryRasxod->createCommand()->getRawSql();

        $subProductType = ProductType::find();
        $subProductType ->select(new \yii\db\Expression('product_type.name'));
        $subProductType ->where('product_type.id = product.product_type_id');
        $subProductType = $subProductType->createCommand()->getRawSql();

        $query->select([
//            new \yii\db\Expression("
//                (
//                IFNULL(({$subReceipt} ),0)
//                ) as receipt
//                "),
//            new \yii\db\Expression("
//                (
//                IFNULL(({$subRasxod}),0)
//                )as rasxod
//                "),
            new \yii\db\Expression("
                (
                IFNULL(({$subProductType}),0)
                )as product_type_name
                "),
            new \yii\db\Expression("
                getProductBalance(product.id, '{$date}', 1) as ostatok
                "),
            'product.id',
            'product.name',
            'product.mark',
            'product.a',
            'product.b'

        ]);

        $query->andFilterWhere([
            'product.product_type_id' => $this->product_type_name,
        ]);
        $query->andFilterWhere(['like', 'product.name', $this->name]);
        $query->andFilterWhere(['like', 'product.mark', $this->mark]);

        $sql = $query->createCommand()->getRawSql();
        $res = Yii::$app->db->createCommand($sql)->queryAll();
        // prd($res);
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $sql,
            'pagination' => FALSE,
        ]);
        return $dataProvider;
    }
}
