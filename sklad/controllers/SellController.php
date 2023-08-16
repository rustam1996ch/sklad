<?php

namespace sklad\controllers;

use Yii;
use sklad\models\Sell;
use sklad\models\Rasxod;
use sklad\models\search\SellSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
// use app\components\MyController;

/**
 * SellController implements the CRUD actions for Sell model.
 */
class SellController extends Controller
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
                    //     'actions' => ['index'],
                    //     'allow' => true,
                    // ],
                    [
                        'actions' => ['no-confirmed','cars','index','view','save','views','creates','print','check','update','delete'],
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

    // public $layout = '/modern-admin-card';

    /**
     * Lists all Sell models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SellSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Sell();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionNotConfirmed($type=0, $id=null)
    {
        if($type != 0){
            return 'NotFoundHttpException';
        }
        $searchModel = new SellSearch();
        $searchModel->status = $type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Sell();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'id' => $id,
        ]);
    }
    public function actionCars()
    {

        $searchModel = new SellSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Sell();

        return $this->render('cars', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Sell model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionViews($id)
    {
        $model=$this->findModel($id);
        $products = Rasxod::find()->where(['sell_id'=>$model->id])->all();

        return $this->renderPartial('views', [
            'model' => $model,
            'products'=>$products,
        ]);
    }
    public function actionStatusUpdate(){

        $id = $_POST['editableKey'];
        $editableIndex = $_POST['editableIndex'];
        $sellStatus = $_POST['Sell'];
        $v = $sellStatus[$editableIndex]['status'];
        $model = $this->findModel($id);
        $model->status = $v;
        $model->save(false);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return true;

    }
    /**
     * Creates a new Sell model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sell();

        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionPrint($id) {
        $products_json = [];
        $product = [];
        $array = [];
        if(!empty($id)){
            $sell = Sell::find()
            ->with('client')
            ->where(['id'=>$id])
            ->asArray()
            ->one();


            $products = Rasxod::find()
            ->where(['sell_id'=>$id])
            ->with('product')
            ->with('packet')
            ->asArray()
            ->all();
            // prd($products);

            foreach ($products as $key => $v) {
                $product['id'] = $v['id'];
                $product['product_id'] =$v['product']['name'];
                $product['cost'] = $v['cost'];
                $product['amount'] = $v['amount'];
                array_push($products_json, $product);
            }
            foreach ($products_json as $key => $item) {
                $key = $item['product_id'];
                if (!array_key_exists($key, $array)) {
                    $array[$key] = array(
                        'product_id' => $item['product_id'],
                        'cost' => $item['cost'],
                        'amount' => $item['amount'],
                    );
                } else {
                    $array[$key]['amount'] = $array[$key]['amount'] + $item['amount'];
                }
            }

            // prd($array);
        }
        return $this->renderPartial('print', [
            'model' => $sell,
            'products'=>$array,
        ]);
    }
    public function actionCreates($id=null)
    {
        $products_json = [];
        $product = [];
        if(!empty($id)){
            $sell = Sell::find()
            ->with('client')
            ->where(['id'=>$id])
            ->asArray()
            ->one();
            $client = json_encode($sell['client'], JSON_PRETTY_PRINT);
            // prd($client);
            $products = Rasxod::find()
            ->where(['sell_id'=>$id])
            ->with('product')
            ->with('packet')
            ->asArray()
            ->all();
            // prd($products);

            foreach ($products as $key => $v) {
                $product['id'] = $v['id'];
                $product['comment'] = '';
                $product['date'] = $v['date'];
                $product['note'] = $v['note'];
                $product['product_id'] = (object)[
                    'id' => $v['product']['id'],
                    'name' => $v['product']['vendor_code'].' '.$v['product']['name'],
                    'cost' => $v['product']['cost'],
                    'price' => $v['product']['price']
                ];
                $product['packet_id'] = $v['packet_id'];
                                             // (object)[
                                             //     'id' => $v['packet']['id'],
                                             //    'product_id' => $v['packet']['product_id'],
                                             //     'amount' => $v['packet']['amount']
                                             // ];
                $product['cost'] = $v['cost'];
                $product['status'] = $v['status'];
                $product['amount'] = $v['amount'];
                $product['sell_id'] = $v['sell_id'];
                array_push($products_json, $product);
            }

            $products = json_encode($products_json, JSON_PRETTY_PRINT);
            // prd($products);
        }else{
            $sell = null;
            $client = null;
            $product['id'] = '';
            $product['comment'] = '';
            $product['date'] = date('Y-m-d');
            $product['note'] = '';
            $product['product_id'] = '';
            $product['packet_id'] = '';
            $product['cost'] = '';
            $product['status'] = 1;
            $product['amount'] = '';
            $product['sell_id'] = '';
            $products_json[]=$product;
            $products = json_encode($products_json, JSON_PRETTY_PRINT);
        }

        // $this->layout = false;
        // Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        return $this->render('form/creates', [
            'sell' => $sell,
            'client'=>$client,
            'products'=>$products,
        ]);
    }

    /**
     * Updates an existing Sell model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionCheck($id)
    {
        $model = $this->findModel($id);
        $model->exit_time = date("Y-m-d H:i:s");
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdate($id)
    {
        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        $model = $this->findModel($id);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSave($id = null)
    {
        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        if ($id == null) {
            $model = new Sell();
        } else {
            $model = $this->findModel($id);
        }

        $result = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result['success'] = 1;
            $result['view'] = $this->render('_form', ['model' => new Sell()]);
        } else {
            $result['success'] = 0;
            $result['view'] = $this->render('_form', ['model' => $model]);
        }
        return $result;
    }

    /**
     * Deletes an existing Sell model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sell model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sell the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sell::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
