<?php

namespace sklad\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use sklad\models\Product;

/**
 * ProductSearch represents the model behind the search form about `sklad\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_type_id', 'x', 'y', 'z', 'a', 'b','status', 'unit_id','layer1_id','layer2_id','layer3_id','layer4_id','layer5_id','gofra1_id','gofra2_id','connertor_id','point_connector','territory_id', 'client_id'], 'integer'],
            [['name', 'mark', 'vendor_code'], 'safe'],
            [['mkv', 'cost', 'price','weight_gofra'], 'number'],
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
        $query = Product::find();/*->orderBy(['id' => SORT_DESC]);*/

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

        $query->joinWith('productType', false);

        // grid filtering conditions
        $query->andFilterWhere([
            'product.id' => $this->id,
            'product_type.client_id' => $this->client_id,
            'product.product_type_id' => $this->product_type_id,
            'product.x' => $this->x,
            'product.y' => $this->y,
            'product.z' => $this->z,
            'product.a' => $this->a,
            'product.b' => $this->b,
            'product.layer1_id' => $this->layer1_id,
            'product.layer2_id' => $this->layer2_id,
            'product.layer3_id' => $this->layer3_id,
            'product.layer4_id' => $this->layer4_id,
            'product.layer5_id' => $this->layer5_id,
            'product.gofra1_id' => $this->gofra1_id,
            'product.gofra2_id' => $this->gofra2_id,
            'product.connertor_id' => $this->connertor_id,
            'product.weight_gofra' => $this->weight_gofra,
            'product.point_connector' => $this->point_connector,
            'product.territory_id' => $this->territory_id,
            'product.mkv' => $this->mkv,
            'product.cost' => $this->cost,
            'product.price' => $this->price,
            'product.status' => $this->status,
            'product.unit_id' => $this->unit_id,
        ]);

        $query->andFilterWhere(['like', 'product.name', $this->name])
            ->andFilterWhere(['like', 'product.mark', $this->mark])
            ->andFilterWhere(['like', 'product.vendor_code', $this->vendor_code]);

        return $dataProvider;
    }
}
