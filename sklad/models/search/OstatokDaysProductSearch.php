<?php


namespace sklad\models\search;

use sklad\models\Product;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class OstatokDaysProductSearch extends Model
{
    public $name;
    public $date;
    public $date1;
    public $date2;
    public $skipEmpties = true;

    public function rules()
    {
        return [
            [['name'], 'string'],
            [['date', 'date1', 'date2'], 'safe'],
        ];

    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $this->load($params);
        $date_array = $this->getDatesFromRange($this->date1, $this->date2);
        //prd($date_array);

        $arrayDays = [];
        foreach ($date_array as $date) {
            $sql = "
                SELECT 
                    IFNULL((SELECT sum(receipt.amount) FROM `receipt` WHERE (receipt.product_id = product.id) AND (`receipt`.`date` BETWEEN '{$date} 00:00' AND '{$date} 23:59') ),0) 
                    as receiptDay,
                    IFNULL((SELECT sum(rasxod.amount) FROM `rasxod` WHERE (rasxod.product_id = product.id) AND (`rasxod`.`date` BETWEEN '{$date} 00:00' AND '{$date} 23:59')), 0)
                     as rasxodDay,
                    '{$date}' as dateday,
                    IFNULL((SELECT sum(receipt.amount) FROM `receipt` WHERE (receipt.product_id = product.id) AND (`receipt`.`date` <= '{$date} 23:59')), 0)
                     as until_day_receipt, 
                    IFNULL((SELECT sum(rasxod.amount) FROM `rasxod` WHERE (rasxod.product_id = product.id) AND (`rasxod`.`date` <= '{$date} 23:59')), 0)
                     as until_day_rasxod,
                    IFNULL((SELECT sum(receipt.amount) FROM `receipt` WHERE (receipt.product_id = product.id) AND (`receipt`.`date` < '{$this->date1}')), 0)
                     as to_this_day_receipt, 
                    IFNULL((SELECT sum(rasxod.amount) FROM `rasxod` WHERE (rasxod.product_id = product.id) AND (`rasxod`.`date` < '{$this->date1}')), 0)
                     as to_this_day_rasxod,
                    IFNULL((SELECT sum(receipt.amount) FROM `receipt` WHERE (receipt.product_id = product.id) AND (`receipt`.`date` <= '{$this->date2}')), 0)
                     as to_latest_day_receipt, 
                    IFNULL((SELECT sum(rasxod.amount) FROM `rasxod` WHERE (rasxod.product_id = product.id) AND (`rasxod`.`date` <= '{$this->date2}')), 0)
                     as to_latest_day_rasxod,
                    (
                        (select to_this_day_receipt) - (select to_this_day_rasxod)
                    ) as to_this_day_ostatok,
                    (
                        (select to_latest_day_receipt) - (select to_latest_day_rasxod)
                    ) as to_latest_day_ostatok,
                    (
                        (select until_day_receipt) - (select until_day_rasxod)
                    ) as ostatokUntilNow,
                    `product`.`id`, `product`.`name`, `product`.`vendor_code` FROM `product` 
            ";
            $res = Yii::$app->db->createCommand($sql)->queryAll();
            array_push($arrayDays, $res);
            //$arrayDays[$date] = $res;
        }
        //prd($arrayDays);
        $arrayRemoveMultiple = [];
        foreach ($arrayDays as $days) {
            foreach ($days as $item) {
                array_push($arrayRemoveMultiple, $item);
            }
        }
        $resultArray = ArrayHelper::index($arrayRemoveMultiple, null, 'id');
        // prd($resultArray);
        return $resultArray;
    }

    public function search2($params)
    {
        $this->load($params);

        $skipEmpties = (int)$this->skipEmpties;

        $res = app()->db->createCommand("
            call balanceProduct('{$this->date1}', '{$this->date2}', {$skipEmpties})
        ")->queryAll();

        return $res;
    }

    public function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        $array = [];
        $interval = new \DateInterval('P1D');

        $realEnd = new \DateTime($end);
        $realEnd->add($interval);

        $period = new \DatePeriod(new \DateTime($start), $interval, $realEnd);

        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        return $array;
    }

}
