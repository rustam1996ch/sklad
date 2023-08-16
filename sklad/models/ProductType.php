<?php

namespace sklad\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_type".
 *
 * @property int $id
 * @property string $name
 * @property int $client_id
 * @property int $parent_id
 * @property int $no
 *
 * @property Product[] $products
 */
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id', 'no', 'client_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['parent_id'], 'default', 'value' => 0, 'skipOnEmpty' => false],
            [['client_id'], 'default', 'value' => NULL, 'skipOnEmpty' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Клиент',
            'name' => 'Наименование',
            'parent_id' => 'Родитель',
            'no' => 'Номер сортировки',
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

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['product_type_id' => 'id']);
    }

    /**
     * Gets query for [[ProductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public static function dDListProductType()
    {
        return self::find()->select("name, id")
            ->indexBy('id')->column();
    }

    public static function parents($asDropdownList = true, $id = null)
    {
        $query = ProductType::find();

        if ($id) {
            $query->where(['not', 'id', $id]);
        }

        if ($asDropdownList) {
            return ArrayHelper::map($query->asArray()->all(), 'id', 'name');
        } else {
            return $query->asArray()->all();
        }

    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {

            return false;
        }

        if ($this->no == '') {
            $last_no = self::find()->where(['client_id' => $this->client_id, 'parent_id' => $this->parent_id])->max('no');
            if ($last_no) {
                $last_no++;
            } else {
                $last_no = 1;
            }

            $this->no = $last_no;
        }

        return true;
    }
}
