<?php

namespace sklad\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "receipt".
 *
 * @property int $id
 * @property string $date
 * @property int $product_id
 * @property int $amount
 * @property int $status
 * @property int $move_who
 * @property int $move_user_id
 * @property float|null $cost
 * @property int|null $packet_id
 *
 * @property Packet $packet
 * @property Product $product
 */
class Receipt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receipt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'product_id', 'amount'], 'required'],
            [['date','move_user_id','cost'], 'safe'],
            [['product_id', 'amount', 'status', 'packet_id','move_user_id','move_who'], 'integer'],
            [['status'], 'default', 'skipOnEmpty' => false, 'value'=>1],
            [['cost'], 'number'],
            [['packet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packet::className(), 'targetAttribute' => ['packet_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'product_id' => 'Продукт',
            'amount' => 'Количество',
            'status' => 'Проверено ',
            'cost' => 'Стоимость',
            'packet_id' => 'Поддон',
        ];
    }

    /**
     * Gets query for [[Packet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPacket()
    {
        return $this->hasOne(Packet::className(), ['id' => 'packet_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductList(){
        $product = Product::find()->all();
        return ArrayHelper::map($product, 'id',
            function($model) {
                return $model['vendor_code'].' - '.$model['name'];
            });
    }

}
