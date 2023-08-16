<?php

namespace sklad\models\search;

use Yii;
use yii\base\Model;

use sklad\models\Product;
use sklad\models\ProductType;
use sklad\models\Packet;
use yii\db\Expression;

/**
 * AnalizSearch represents the model behind the search form of `app\models\Analiz`.
 */
class BufferOstatokProductSearch extends Model
{
	
	public $name;
	public $date;
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

        $subQueryPacket = Packet::find();
        $subQueryPacket ->select(new \yii\db\Expression('sum(packet.left)'));
        $subQueryPacket ->where('packet.product_id = product.id');
        $subQueryPacket ->andWhere('packet.space = 0');
        $subQueryPacket ->andWhere(new Expression('not exists (select r.id from receipt r 
        where r.packet_id=packet.id)'));
        $subQueryPacket ->andFilterWhere(['<=', 'packet.date', $this->date]);
        $subPacket = $subQueryPacket->createCommand()->getRawSql();

        $subProductType = ProductType::find();
        $subProductType ->select(new \yii\db\Expression('product_type.name'));
        $subProductType ->where('product_type.id = product.product_type_id');
        $subProductType = $subProductType->createCommand()->getRawSql();
        
        $query->select([
            new \yii\db\Expression("
                (
                IFNULL(({$subPacket} ),0)
                ) as ostatok
                "),
            new \yii\db\Expression("
                (
                IFNULL(({$subProductType}),0)
                )as product_type_name
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