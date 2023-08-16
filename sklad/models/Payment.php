<?php

namespace sklad\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string $date
 * @property int $client_id
 * @property float $amount
 * @property string $note
 *
 * @property Client $client
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'client_id', 'amount'], 'required'],
            [['date'], 'safe'],
            [['client_id'], 'integer'],
            [['amount'], 'number'],
            [['note'], 'string'],
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
            'client_id' => 'Клиент ',
            'amount' => 'Cумма',
            'note' => 'Примечание',
        ];
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
}
