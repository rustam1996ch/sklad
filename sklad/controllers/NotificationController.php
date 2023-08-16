<?php


namespace sklad\controllers;

use sklad\models\Sell;
use yii\web\Controller;

class NotificationController extends Controller
{
    public $enableCsrfValidation = false;

    //Sell
    public function actionSell()
    {

        $list = Sell::find()->where(['status' => 0])->all();


        return $this->render('sell', [
            'list' => $list
        ]);

    }

    public function actionSellList()
    {

    }

    public function actionSellDetail()
    {

    }

    public function actionSellConfirm()
    {

    }


    //PacketMoved

    public function actionPacketMoved()
    {

    }

    public function actionPacketMovedList()
    {

    }

    public function actionPacketMovedDetail()
    {

    }

    public function actionPacketMovedConfirm()
    {

    }
}
