<?php

namespace sklad\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "sell".
 *
 * @property int $id
 * @property string $date
 * @property string|null $car_number
 * @property string $note
 * @property int $client_id
 * @property int $status
 *
 * @property Rasxod[] $rasxods
 * @property Client $client
 */
class Sell extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sell';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['shipped_time'],
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public $rasxodlar;

    private $cachedRasxodSumma = null;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'client_id'], 'required'],
            [['date', 'rasxodlar', 'contract_date', 'shipped_time', 'exit_time'], 'safe'],
            [['note'], 'string'],
            [['client_id', 'status', 'invoice_no', 'contract_no'], 'integer'],
            [['car_number'], 'string', 'max' => 45],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
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
            'car_number' => 'Номер машины',
            'note' => 'Описание',
            'client_id' => 'Клиент',
            'status' => 'Проверено',
            'invoice_no' => 'счет №',
            'contract_no' => 'Дог №',
            'contract_date' => 'Дата контракта',
            'shipped_time' => 'Время доставки',
            'exit_time' => 'Время выхода',
        ];
    }

    // public function afterSave($insert, $attr = NULL)
    // {
    //     $transaction = Yii::$app->db->beginTransaction();
    //     try{
    //         $res = Rasxod::saveRelationRasxod($this->rasxodlar, $this->id,$this->date);
    //         if($res){
    //             $transaction->commit();
    //             return true;
    //         }
    //         else{
    //             $transaction->rollback();
    //             return false;
    //         }
    //     }catch(\Exception $e){
    //             $transaction->rollback();
    //     }
    //     return parent::afterSave($insert, $attr=NULL);
    // }

    /**
     * Gets query for [[Rasxods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxods()
    {
        return $this->hasMany(Rasxod::className(), ['sell_id' => 'id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    public function getRasxodSumma()
    {
        return \sklad\models\Rasxod::find()->where(['sell_id' => $this->id])->sum('amount*cost');
    }

    public function getRasxodAmount()
    {
        return \sklad\models\Rasxod::find()->where(['sell_id' => $this->id])->sum('amount');
    }


    public function getProductsInline()
    {
        $rows = \sklad\models\Rasxod::find()
            ->joinWith('product', false)
            ->where(['sell_id' => $this->id])
            ->groupBy(['rasxod.product_id'])
            ->orderBy(['amount' => SORT_DESC])
            ->select(new Expression('product.vendor_code, product.name, sum(rasxod.amount) as amount'))
            ->asArray()->all();

        $arr = [];

        if (count($rows) > 1) {
            foreach ($rows as $row) {
                $title = $row['name'];
                $arr[] = "<span style='white-space: nowrap' title='{$title}'>" . $row['vendor_code'] . ' &mdash; ' . $row['amount'] . 'шт' . '</span>';
            }
            return implode(', ', $arr);

        } elseif (count($rows) == 1) {
            $title = $rows[0]['name'];
            return "<span style='white-space: nowrap' title='{$title}'>" . $rows[0]['vendor_code'] . '</span>';
        }

    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        Rasxod::deleteAll(['sell_id' => $this->id]);

        return true;
    }
}
