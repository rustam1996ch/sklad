<?php

namespace sklad\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $h_raqam
 * @property string|null $bank
 * @property string|null $city
 * @property string|null $mfo
 * @property string|null $inn
 * @property string|null $okonx
 * @property string|null $director
 * @property string|null $basis
 * @property string|null $doc_date
 *
 * @property Payment[] $payments
 * @property Sell[] $sells
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['address'], 'string'],
            // [['doc_date'], 'safe'],
            [['name'], 'string', 'max' => 1000],
            [['phone', 'h_raqam', 'city'], 'string', 'max' => 45],
            [['bank'], 'string', 'max' => 100],
            [['mfo', 'okonx'], 'string', 'max' => 5],
            [['inn'], 'string', 'max' => 20],
            [['director', 'basis'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'h_raqam' => 'Р/с',
            'bank' => 'Банк',
            'city' => 'Город',
            'mfo' => 'Mfo',
            'inn' => 'ИНН',
            'okonx' => 'ОКОНХ',
            'director' => 'ДИРЕКТОР',
            'basis' => 'Basis',
            // 'doc_date' => 'Doc Date',
        ];
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Sells]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSells()
    {
        return $this->hasMany(Sell::className(), ['client_id' => 'id']);
    }

    public static function dDListClient()
     {
        return self::find()->select("name, id")
                            ->indexBy('id')->column();
    }
}
