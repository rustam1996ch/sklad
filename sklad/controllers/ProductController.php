<?php

namespace sklad\controllers;

use sklad\models\Connertor;
use sklad\models\Gofra;
use sklad\models\Layer;
use sklad\models\Territory;
use Yii;
use sklad\models\Product;
use sklad\models\search\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
                        'actions' => ['amount-in-packet','save','create','view','index','update','delete'],
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Product();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id = (int)$_GET['id'];
        $product = Product::find()->where(['id' => $id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;

        return $this->renderAjax('view',[
            'product' => $product,
        ]);

    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->unit_id = 1;

        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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
            $model = new Product();
        } else {
            $model = $this->findModel($id);
        }

        $result = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result['success'] = 1;
            $result['view'] = $this->render('_form', ['model' => new Product()]);
        } else {
            $result['success'] = 0;
            $result['view'] = $this->render('_form', ['model' => $model]);
        }
        return $result;
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionProductTypeId(){//product-type-id
        if (isset($_GET['product_type_id'])) {
            $product_type_id = (int)$_GET['product_type_id'];
            $product = Product::find()->where(['product_type_id' => $product_type_id])->orderBy(['product_type_id' => SORT_DESC])->one();
            $territory = Territory::find()->where(['id' => $product->territory_id])->one()->name;
            $layer1 = Layer::find()->where(['id' => $product->layer1_id])->one()->name;

            if(empty($product->layer2_id)) $layer2 = '';
            else $layer2 = Layer::find()->where(['id' => $product->layer2_id])->one()->name;

            if(empty($product->layer3_id)) $layer3 = '';
            else $layer3 = Layer::find()->where(['id' => $product->layer3_id])->one()->name;

            if(empty($product->layer4_id)) $layer4 = '';
            else $layer4 = Layer::find()->where(['id' => $product->layer4_id])->one()->name;

            if(empty($product->layer5_id)) $layer5 = '';
            else $layer5 = Layer::find()->where(['id' => $product->layer5_id])->one()->name;

            if(empty($product->gofra1_id)) $gofra1 = '';
            else $gofra1 = Gofra::find()->where(['id' => $product->gofra1_id])->one()->name;

            if(empty($product->gofra2_id)) $gofra2 = '';
            else $gofra2 = Gofra::find()->where(['id' => $product->gofra2_id])->one()->name;

            if(empty($product->connertor_id)) $connertor = '';
            else $connertor = Connertor::find()->where(['id' => $product->connertor_id])->one()->name;

        }else{
            $product = [];
            $territory = '';
            $layer1 = '';
            $layer2 = '';
            $layer3 = '';
            $layer4 = '';
            $layer5 = '';
            $gofra1 = '';
            $gofra2 = '';
            $connertor = '';
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'product' => $product,
            'territory' => $territory,
            'layer1' => $layer1,
            'layer2' => $layer2,
            'layer3' => $layer3,
            'layer4' => $layer4,
            'layer5' => $layer5,
            'gofra1' => $gofra1,
            'gofra2' => $gofra2,
            'connertor' => $connertor,
        ];
    }

    public function actionAmountInPacket(){

        $products = Product::find()->all();
        foreach ($products as $product){
            $t = Product::find()->where(['id' => $product->id])->one();
            $t->amount_in_packet = rand(15,40);
//            $t->price = rand(200,1000);
            $t->save(false);
        }
        echo 'OK';
    }

}
