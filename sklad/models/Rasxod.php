<?php

namespace sklad\models;

use Yii;
use sklad\models\Packet;

/**
 * This is the model class for table "rasxod".
 *
 * @property int $id
 * @property string $date
 * @property string $amount
 * @property int $status
 * @property float $cost
 * @property int $product_id
 * @property int|null $packet_id
 * @property int|null $sell_id
 * @property string $note
 *
 * @property Packet $packet
 * @property Product $product
 * @property Sell $sell
 */
class Rasxod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rasxod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'amount', 'cost', 'product_id'], 'required'],
            [['status', 'product_id', 'packet_id', 'sell_id'], 'integer'],
            [['date'], 'safe'],
            [['cost'], 'number'],
            [['note'], 'string'],
            [['amount'], 'string', 'max' => 45],
            [['packet_id'], 'exist', 'skipOnError' => false, 'targetClass' => Packet::className(), 'targetAttribute' => ['packet_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['sell_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sell::className(), 'targetAttribute' => ['sell_id' => 'id']],
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
            'amount' => 'Количество',
            'status' => 'Статус',
            'cost' => 'Стоимость',
            'product_id' => 'Продукт',
            'packet_id' => 'Поддон',
            'sell_id' => 'Продам',
            'note' => 'Примечание',
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

    /**
     * Gets query for [[Sell]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSell()
    {
        return $this->hasOne(Sell::className(), ['id' => 'sell_id']);
    }

    public static function saveRelationRasxod($items, $sell_id,$sana)
    {
        //items bu rasxodlar vue js qoshilgan tavarlar
        if (!$items) {
            return;
        }
        foreach ($items as $key => $item) {
            if (!empty($item['id'])) {
                $rasxodItem = Rasxod::findOne(['id' => $item['id']]);
            } else {

                $rasxodItem = new self;
            }

            $rasxodItem->date = $sana;
            $rasxodItem->amount = $item['amount'];
            $rasxodItem->cost = $item['cost'];
            $rasxodItem->product_id = $item['product_id']['id'];
            if(!empty($item['packet_id'])) {
                $rasxodItem->packet_id = (int)(substr((string)($item['packet_id']), 1, -1));//['id'] select bolsa commentdan chiqaras
            }
            $rasxodItem->status = $item['status'];
            $rasxodItem->note = $item['note'];
            $rasxodItem->sell_id = $sell_id;
            $rasxodItem->save();
            if(!empty($item['packet_id'])){
                $packetOne = Packet::find()->where(['id'=>(int)(substr((string)($item['packet_id']),1,-1))])->one();
                $packetOne->left = $packetOne->left-$item['amount'];
                $packetOne->save();
            }
        }
        return true;

    }
}
