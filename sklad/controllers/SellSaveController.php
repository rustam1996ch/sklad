<?php
namespace sklad\controllers;
use Yii;


use sklad\models\Client;
use sklad\models\Product;
use sklad\models\Rasxod;
use sklad\models\Packet;
use sklad\models\Sell;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\rest\Controller;

/**
 * Default controller for the `api` module
 */
class SellSaveController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors = array_merge($behaviors, [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'products' => ['GET'],
                    'packets' => ['GET'],
                    'clients' => ['GET'],
                    'post' => ['POST'],
                    'post-sell' => ['POST'],
                    'put-sell' => ['POST'],
                    'delete-product' => ['DELETE']

                ],
            ],
        ]);
        return array_merge($behaviors, [
            [
                'class' => 'yii\filters\ContentNegotiator',
                // 'only' => [],
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],


            ],
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionProducts()
    {
        $product_array = [];
        $json_product = [];
        $products = Product::find()
            ->select(['id','name','cost','price','vendor_code'])
            ->orderBy("id desc")
            ->all();

        foreach ($products as $v) {
            $product_array['id'] = $v->id;
            $product_array['name'] = $v->vendor_code.' - '.$v->name;
            $product_array['cost'] = $v->cost;
            $product_array['price'] = $v->price;
            array_push($json_product, $product_array);
        }
        return self::successResponse($json_product);
    }

    public function actionPackets($id)
    {
        if(empty($id)){
            $packets = '';
        }else{
            $packets = Packet::find()->where(['id'=>$id])
                ->with('product')
                ->orderBy("id desc")
                ->asArray()
                ->one();
            $packets['product']['name'] = $packets['product']['vendor_code'].' - '.$packets['product']['name'];
        }



        return self::successResponse($packets);
    }

    public function actionClients()
    {
        $clients = Client::find()
            ->orderBy("id desc")
            ->all();

        return self::successResponse($clients);
    }

    public function actionPostSell()
    {
        $response = self::getBody();
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = new Sell();
            $model->date = $response['date'];
            $model->client_id = $response['client_id']['id'];
            $model->contract_date = $response['contract_date'];
            $model->contract_no = $response['contract_no'];
            $model->invoice_no = $response['invoice_no'];
            $model->car_number = $response['car_number'];
            $model->note = $response['note'];
            $res = $model->save();
            $sell_id = $model->id;

            foreach ($response['rasxodlar'] as $item) {
                if($item['product_id'] == '' && $item['packet_id'] == ''){
                    continue;
                }
                $rasxodItem = new Rasxod();

                $rasxodItem->date = $response['date'];
                $rasxodItem->amount = $item['amount'];
                $rasxodItem->cost = $item['cost'];
                $rasxodItem->product_id = $item['product_id']['id'];
                if(!empty($item['packet_id'])) {
                    $rasxodItem->packet_id = (int)(substr((string)($item['packet_id']), 1, -1));//['id'] select bolsa commentdan chiqaras
                }
                $rasxodItem->status = $item['status'];
                $rasxodItem->note = $item['note'];
                $rasxodItem->sell_id = $sell_id;
                $res = $rasxodItem->save();

                if(!empty($item['packet_id'])){
                    $packetOne = Packet::find()->where(['id'=>(int)(substr((string)($item['packet_id']),1,-1))])->one();
                    $packetOne->left = $packetOne->left-$item['amount'];
                    $packetOne->save();
                }
            }

            if($res){
                $transaction->commit();
                return self::successResponse();
            }else{
                $transaction->rollback();
                return self::errorResponse($rasxodItem->getErrors());
            }
        }catch(\Exception $e){
            $transaction->rollback();
        }

        // if($res){
        //     return self::successResponse();
        // }

        // $model = new Sell();

        // if ($model->load($response, '')) {
        //     $model->client_id = $response['client_id']['id'];
        //     $model->save();
        //     return self::successResponse();
        // }
        return self::errorResponse($model->getErrors());
    }

    public function actionPutSell()
    {
        $response = self::getBody();

        if (!isset($response['id'])) {
            return self::errorResponse();
        }

        $model = Sell::findOne($response['id']);

        if (!$model) {
            return self::errorResponse(null, 404);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try{

            $model->date = $response['date'];
            $model->client_id = $response['client_id']['id'];
            $model->contract_date = $response['contract_date'];
            $model->contract_no = $response['contract_no'];
            $model->invoice_no = $response['invoice_no'];
            $model->car_number = $response['car_number'];
            $model->note = $response['note'];
            $res = $model->save();

            $sell_id = $model->id;

            foreach ($response['rasxodlar'] as $item) {
                if($item['product_id'] == '' && $item['packet_id'] == ''){
                    continue;
                }
                if(!empty($item['id'])){
                    $rasxodItem = Rasxod::findOne($item['id']);
                }else{
                    $rasxodItem = new Rasxod();
                }

                $rasxodItem->date = $response['date'];
                $rasxodItem->amount = $item['amount'];
                $rasxodItem->cost = $item['cost'];
                $rasxodItem->product_id = $item['product_id']['id'];
                if(!empty($item['packet_id'])) {
                    if(strlen($item['packet_id']) == Packet::barCodeLength){
                        $rasxodItem->packet_id = (int)(substr((string)($item['packet_id']), 1, -1));//['id'] select bolsa commentdan chiqaras
                    }
                    $rasxodItem->packet_id = (int)($item['packet_id']);
                }
                $rasxodItem->status = $item['status'];
                $rasxodItem->note = $item['note'];
                $rasxodItem->sell_id = $sell_id;
                $res = $rasxodItem->save();

                if(!empty($item['packet_id'])){
                    if(strlen($item['packet_id']) == Packet::barCodeLength){
                        $packetOne = Packet::find()->where(['id'=>(int)(substr((string)($item['packet_id']), 1, -1))])->one();
                    }else{
                        $packetOne = Packet::find()->where(['id'=>$item['packet_id']])->one();
                    }
                    $packetOne->left = $packetOne->left-$item['amount'];
                    $packetOne->save();
                }
            }

            if($res){
                $transaction->commit();
                return self::successResponse();
            }else{
                $transaction->rollback();
                return self::errorResponse($rasxodItem->getErrors());
            }
        }catch(\Exception $e){
            $transaction->rollback();
        }

        // $response = self::getBody();



        // if ($model->load($response, '')) {
        //     $model->client_id = $response['client_id']['id'];
        //     $model->save();
        //     return self::successResponse();
        // }
        return self::errorResponse($model->getErrors());
    }



    public function actionDeleteAnaliz()
    {
        if (!($id = \Yii::$app->request->get("id"))) {
            return self::errorResponse(null, 400);
        }


        $model = Analiz::findOne($id);

        if (!$model) {
            return self::errorResponse(null, 404);
        }

        $model->delete();
        return self::successResponse();
    }

    public function actionDeleteProduct()
    {
        if (!($id = \Yii::$app->request->get("id"))) {
            return self::errorResponse(null, 400);
        }
        $model = Rasxod::findOne($id);
        if (!$model) {
            return self::errorResponse(null, 404);
        }

        $model->delete();

        return self::successResponse();
    }

    private static function successResponse($result = null)
    {
        return ['status' => true, "result" => $result];
    }

    private static function errorResponse($errors = null, $statusCode = 400)
    {
        \Yii::$app->response->statusCode = $statusCode;
        return ['status' => false, "errors" => $errors];
    }

    private static function getBody()
    {
        return json_decode(file_get_contents("php://input"), true);
    }
}
