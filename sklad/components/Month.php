<?php


namespace hr\components;


class Month extends \yii\base\BaseObject
{
    public function getMonth(){
        return ['01' => 'Январь', '02' => 'Февраль', '03'=> 'Март', '04'=> 'Апреля', '05'=> 'Май', '06'=> 'Июнь', '07'=> 'Июль', '08'=> 'Август', '09'=> 'Сентябрь', '10'=> 'Октября', '11'=> 'Ноябрь', '12'=> 'Декабрь'];
    }
}