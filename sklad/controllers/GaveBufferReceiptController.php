<?php


namespace sklad\controllers;

use sklad\models\Packet;
use sklad\models\Product;
use sklad\models\Receipt;
use Yii;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Json;
use yii\web\Response;
use yii\filters\AccessControl;

class GaveBufferReceiptController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // [
                    //     'actions' => ['index'],
                    //     'allow' => true,
                    // ],
                    [
                        'actions' => ['find-packet-id','post-reciept','save','create','view','index','update','delete'],
                        'allow' => (!\Yii::$app->user->isGuest)?true:false,
                    ],
                    [
                        'roles' => ['@'],
                        'allow' => true
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $sql = "SELECT 
                (SELECT name FROM `product` WHERE receipt.product_id = product.id)
                 as productName,
                 (SELECT vendor_code FROM `product` WHERE receipt.product_id = product.id)
                 as vendor_code,
                 (
                    SELECT CONCAT(vendor_code , ' ' , productName)
                 ) as productName2,
                `receipt`.`id`, `receipt`.`product_id`, `receipt`.`packet_id`, `receipt`.`amount`
                FROM `receipt`
                INNER JOIN `packet`
                ON `receipt`.packet_id = `packet`.id
                WHERE `packet`.space = 0
                GROUP BY `packet_id`, `product_id`";
        $receipts = Yii::$app->db->createCommand($sql)->queryAll();
        return $this->render('index', [
           'receipts' => $receipts,
        ]);
    }

    public function actionPostReceipt()
    {
        $post = app()->request->post('json');
        $data = Json::decode($post);
        foreach ($data as $item){
            if($item['product_id']['amount'] - $item['amount'] > 0){
                $receipt = new Receipt();
                $receipt->date = $item['date'];
                $receipt->product_id = $item['product_id']['product_id'];
                $receipt->packet_id = $item['product_id']['packet_id'];
                $receipt->amount = $item['amount'];//$item['product_id']['amount'] - $item['amount']
                $receipt->move_user_id = app()->user->identity->id;
                $receipt->status = 1;
                $t = $receipt->save(false);
                if($t){
                    $packet = Packet::find()->where(['id' => $item['product_id']['packet_id']])->one();
                    $packet->amount = $item['product_id']['amount'] - $item['amount'];
                    $packet->save(false);

                    $receipt2 = Receipt::find()->where(['packet_id' => $item['product_id']['packet_id']])->one();
                    $receipt2->amount = $item['product_id']['amount'] - $item['amount'];
                    $receipt2->save(false);
                }
            }else{
                $packet = Packet::find()->where(['id' => $item['product_id']['packet_id']])->one();
                $packet->space = 1;
                $packet->save(false);
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }

    public function actionFindPacketId(){
        $booleanBuffer = false;
        $post = app()->request->post('json');
        $packet_id = Json::decode($post);
        $buffer = Receipt::find()->where(['packet_id' => $packet_id])->one();
        $productForList = [];
        if(isset($buffer)){
            $booleanBuffer = true;
            $product = Product::find()->where(['id'=>$buffer->product_id])->one();
            $productForList['productName'] = $product->name;
            $productForList['id'] = $buffer->id;
            $productForList['product_id'] = $buffer->product_id;
            $productForList['packet_id'] = $buffer->packet_id;
            $productForList['amount'] = $buffer->amount;
            $productForList['cost'] = $product->cost;
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'buffer' => $buffer,
            'booleanBuffer' => $booleanBuffer,
            'productForList' => $productForList,
        ];
    }

}
