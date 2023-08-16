<?php

namespace sklad\controllers;

use common\models\User;
use sklad\models\Packet;
use sklad\models\Product;
use sklad\models\search\PacketSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PacketController implements the CRUD actions for Packet model.
 */
class PacketController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // [
                    //     'actions' => ['create'],
                    //     'allow' => true,
                    // ],
                    [
                        'actions' => ['modal-body', 'id-save', 'sub-query', 'product-search', 'print3', 'print-a4', 'product-amount-in-packet-change', 'product-amount-in-packet', 'product-information', 'save', 'create', 'view', 'index', 'update', 'delete'],
                        'allow' => (!\Yii::$app->user->isGuest) ? true : false,
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

    // public $layout = '/modern-admin-card';

    /**
     * Lists all Packet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $products = Product::find()->all();
        $model = new Packet();
        $searchModel = new PacketSearch();

        $query = Packet::find()->orderBy(['id' => SORT_DESC]);
        $sql = $this->subQuery($query);
        $pacets = Yii::$app->db->createCommand($sql)->queryAll();

        return $this->render('index', [
            'model' => $model,
            'pacets' => $pacets,
            'products' => $products,
            'searchModel' => $searchModel
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Packet();

        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        $model = $this->findModel($id);

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    public function actionSave($id = null)
    {
        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        if ($id == null) {
            $model = new Packet();
        } else {
            $model = $this->findModel($id);
        }

        $result = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result['id'] = $model->id;
            $result['success'] = 1;
            $result['view'] = $this->render('_form', ['model' => new Packet()]);
        } else {
            $result['success'] = 0;
            $result['view'] = $this->render('_form', ['model' => $model]);
        }
        return $result;
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Packet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionProductInformation()
    {

        if (isset($_GET['product_id'])) {
            $product_id = (int)$_GET['product_id'];
        }

        $product = Product::find()->where(['id' => $product_id])->one();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->renderAjax('information', [
            'product' => $product,
        ]);
    }

    public function actionProductAmountInPacket()
    {
        if (isset($_GET['product_id'])) {
            $product_id = (int)$_GET['product_id'];
        }

        $product = Product::find()->where(['id' => $product_id])->one();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'amount_in_packet' => $product->amount_in_packet
        ];
    }

    public function actionProductAmountInPacketChange()
    {
        if (isset($_GET['product_id']) && isset($_GET['amount_in_packet'])) {
            $product_id = (int)$_GET['product_id'];
            $amount_in_packet = (int)$_GET['amount_in_packet'];
        }

        $product = Product::find()->where(['id' => $product_id])->one();
        $product->amount_in_packet = $amount_in_packet;
        $product->save(false);

//        Yii::$app->response->format = Response::FORMAT_JSON;
//        return [
//            'amount_in_packet' => $product->amount_in_packet
//        ];
    }

    public function actionPrint3($id, $amount_in_packet, $butunqismi, $qoldiqqismi, $full_name)
    {
        $this->layout = false;
        return $this->renderPartial('print-barcode3', [
            'id' => $id,
            'amount_in_packet' => $amount_in_packet,
            'butunqismi' => $butunqismi,
            'qoldiqqismi' => $qoldiqqismi,
            'full_name' => $full_name
        ]);

    }

    public function actionPrintA4($id)
    {
        $this->layout = false;
        return $this->renderPartial('print-a4', [
            'id' => $id,
        ]);

    }

    public function actionProductSearch()
    {
        $products = Product::find()->all();
        $model = new Packet();
        $searchModel = new PacketSearch();

        $type = $_GET['type'];
        $packets = [];
        if ($type == 1) {
            $dateBegin = $_GET['startStr'];
            $dateEnd = $_GET['endStr'];
            $query = Packet::find()->where(['between', 'date', $dateBegin, $dateEnd])->orderBy(['date' => SORT_ASC]);
            $sql = $this->subQuery($query);
            $packets = Yii::$app->db->createCommand($sql)->queryAll();
        } elseif ($type == 2) {
            $productId = (int)$_GET['productId'];
            $query = Packet::find()->where(['product_id' => $productId]);
            $sql = $this->subQuery($query);
            $packets = Yii::$app->db->createCommand($sql)->queryAll();
        } elseif ($type == 3) {
            $productId = (int)$_GET['productId'];
            $dateBegin = $_GET['startStr'];
            $dateEnd = $_GET['endStr'];
            $query = Packet::find()->where(['product_id' => $productId])->andWhere(['between', 'date', $dateBegin, $dateEnd])->orderBy(['date' => SORT_ASC]);
            $sql = $this->subQuery($query);
            $packets = Yii::$app->db->createCommand($sql)->queryAll();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->renderAjax('search-table', [
            'model' => $model,
            'pacets' => $packets,
            'products' => $products,
            'searchModel' => $searchModel
        ]);
    }

    private function subQuery($query)
    {

        $subQueryProduct = Product::find();
        $subQueryProduct->select(new \yii\db\Expression('amount_in_packet'));
        $subQueryProduct->where('packet.product_id = product.id');
        $sqlProductAmountInPacket = $subQueryProduct->createCommand()->getRawSql();

        $subQueryProductName = Product::find();
        $subQueryProductName->select(new \yii\db\Expression('name'));
        $subQueryProductName->where('packet.product_id = product.id');
        $sqlProductName = $subQueryProductName->createCommand()->getRawSql();

        $subQueryUserName = User::find();
        $subQueryUserName->select(new \yii\db\Expression('username'));
        $subQueryUserName->where('packet.user_id = user.id');
        $sqlUserName = $subQueryUserName->createCommand()->getRawSql();

        $subQueryFullName = User::find();
        $subQueryFullName->select(new \yii\db\Expression('full_name'));
        $subQueryFullName->where('packet.user_id = user.id');
        $sqlFullName = $subQueryFullName->createCommand()->getRawSql();

        $query->select([
            new \yii\db\Expression("
                (
                IFNULL(({$sqlProductAmountInPacket}), 0)
                ) as amount_in_packet
                "),
            new \yii\db\Expression("
                ({$sqlProductName})
                 as productName
                "),
            new \yii\db\Expression("
                ({$sqlUserName})
                 as userName
                "),
            new \yii\db\Expression("
                ({$sqlFullName})
                 as full_name
                "),
            new \yii\db\Expression('
                (
                (select packet.left) % (select amount_in_packet)
                ) as qoldiqQismi
                '),
            new \yii\db\Expression('
                (
                (select packet.left) / (select amount_in_packet)
                ) as butunQismi
                '),
            'packet.*',
        ]);

        $sql = $query->createCommand()->getRawSql();
        return $sql;

    }

    public function actionIdSave($id)
    {
        $packet = new Packet();
        $packet->id = $id;
        $packet->date = '2020-02-' . rand(1, 26);
        $packet->product_id = rand(5, 15);
        $packet->amount = rand(100, 200);
        $packet->user_id = rand(1, 5);
        $packet->note = 'Note Text';
        $packet->left = rand(50, 100);
        $packet->save();
        echo "Ok";
    }

    public function actionModalBody()
    {
        $id = $_POST['packetId'];
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->renderAjax('warning-packet-modal', [
            'id' => $id,
        ]);
    }

}
