<?php

namespace sklad\models;

use Yii;

/**
 * This is the model class for table "connertor".
 *
 * @property int $id
 * @property string $name
 *
 * @property Receipt[] $receipts
 */
class Connertor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'connertor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
        ];
    }

    /**
     * Gets query for [[Receipts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['connertor_id' => 'id']);
    }
}
