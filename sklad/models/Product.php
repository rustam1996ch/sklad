<?php

namespace sklad\models;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property int $product_type_id
 * @property string|null $mark
 * @property string|null $vendor_code
 * @property int|null $x
 * @property int|null $y
 * @property int|null $z
 * @property float|null $mkv
 * @property float|null $cost
 * @property float|null $price
 * @property int $status
 * @property int $unit_id
 * @property float|null $a
 * @property float|null $b
 * @property string|null $fraction
 * @property int|null $amount_in_packet
 * @property int|null $layer1_id
 * @property int|null $layer2_id
 * @property int|null $layer3_id
 * @property int|null $layer4_id
 * @property int|null $layer5_id
 * @property int|null $gofra1_id
 * @property int|null $gofra2_id
 * @property int|null $connertor_id
 * @property float|null $weight_gofra
 * @property int|null $point_connector
 * @property int|null $territory_id
 *
 * @property Packet[] $packets
 * @property Connertor $connertor
 * @property Territory $territory
 * @property ProductType $productType
 * @property Unit $unit
 * @property Rasxod[] $rasxods
 * @property Receipt[] $receipts
 */
class Product extends \yii\db\ActiveRecord
{
    public $client_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'product_type_id', 'unit_id'], 'required'],
            [['product_type_id', 'x', 'y', 'z', 'status', 'unit_id', 'amount_in_packet'], 'integer'],
            [['mkv', 'cost', 'price', 'a', 'b', 'weight_gofra'], 'number'],
            [['name', 'mark'], 'string', 'max' => 255],
            [['vendor_code'], 'string', 'max' => 80],
            [['fraction'], 'string'],
            [['layer1_id', 'layer2_id', 'layer3_id', 'layer4_id', 'layer5_id', 'gofra1_id', 'gofra2_id', 'connertor_id', 'point_connector'], 'safe'],
            [['vendor_code'], 'unique'],
            [['connertor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Connertor::className(), 'targetAttribute' => ['connertor_id' => 'id']],
            [['territory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Territory::className(), 'targetAttribute' => ['territory_id' => 'id']],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['product_type_id' => 'id']],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit_id' => 'id']],
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
            'client_id' => 'Клиент',
            'product_type_id' => 'Категория',
            'mark' => 'Марка',
            'vendor_code' => 'Артикул',
            'x' => 'Длина',
            'y' => 'Ширина',
            'z' => 'Высота',
            'a' => 'Длина заготовки',
            'b' => 'Ширина заготовки',
            'mkv' => 'м кв',
            'fraction' => 'Кол-во заготовок на коробку',
            'cost' => 'Себестоимость',
            'price' => 'Цена',
            'status' => 'Статус',
            'unit_id' => 'Единица измерения',
            'layer1_id' => '1 слой',
            'layer2_id' => '2 слой',
            'layer3_id' => '3 слой',
            'layer4_id' => '4 слой',
            'layer5_id' => '5 слой',
            'gofra1_id' => 'Тип гофры 1',
            'gofra2_id' => 'Тип гофры 2',
            'connertor_id' => 'Соед',
            'weight_gofra' => 'Весь загатовки',
            'point_connector' => 'Точка соед',
            'territory_id' => 'Территория',
            'amount_in_packet' => 'Количество в упаковки',
        ];
    }

    /**
     * Gets query for [[Packets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPackets()
    {
        return $this->hasMany(Packet::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Connertor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConnertor()
    {
        return $this->hasOne(Connertor::className(), ['id' => 'connertor_id']);
    }

    /**
     * Gets query for [[Territory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTerritory()
    {
        return $this->hasOne(Territory::className(), ['id' => 'territory_id']);
    }

    /**
     * Gets query for [[ProductType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'product_type_id']);
    }

    /**
     * Gets query for [[ProductType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id'])->via('productType');
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    /**
     * Gets query for [[Rasxods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxods()
    {
        return $this->hasMany(Rasxod::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Receipts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['product_id' => 'id']);
    }

    public function getLayer1()
    {
        return $this->hasOne(Layer::className(), ['id' => 'layer1_id']);
    }

    public function getLayer2()
    {
        return $this->hasOne(Layer::className(), ['id' => 'layer2_id']);
    }

    public function getLayer3()
    {
        return $this->hasOne(Layer::className(), ['id' => 'layer3_id']);
    }

    public function getLayer4()
    {
        return $this->hasOne(Layer::className(), ['id' => 'layer4_id']);
    }

    public function getLayer5()
    {
        return $this->hasOne(Layer::className(), ['id' => 'layer5_id']);
    }

    public function getGofra1()
    {
        return $this->hasOne(Gofra::className(), ['id' => 'gofra1_id']);
    }

    public function getGofra2()
    {
        return $this->hasOne(Gofra::className(), ['id' => 'gofra2_id']);
    }

    public function getLayersInline()
    {
        $arr = [];
        if ($this->layer1) {
            $arr[] = $this->layer1->name;
        }
        if ($this->layer2) {
            $arr[] = $this->layer2->name;
        }
        if ($this->layer3) {
            $arr[] = $this->layer3->name;
        }
        if ($this->layer4) {
            $arr[] = $this->layer4->name;
        }
        if ($this->layer5) {
            $arr[] = $this->layer5->name;
        }

        return implode('/', $arr);
    }


    public function getGofrasInline()
    {
        $arr = [];
        if ($this->gofra1) {
            $arr[] = $this->gofra1->name;
        }
        if ($this->gofra2) {
            $arr[] = $this->gofra2->name;
        }

        return implode('/', $arr);
    }


    public function getDimensions()
    {
        $str = "{$this->x}*{$this->y}*{$this->z}; {$this->a}*{$this->b}; ";

        if ($this->mkv) {
            $str .= round_decimal(app()->formatter->asDecimal($this->mkv, 2));
        } else {
            $str .= round_decimal(app()->formatter->asDecimal($this->a * $this->b / 1000000, 2));
        }

        $str .= 'кв.м';

        return $str;
    }

}
