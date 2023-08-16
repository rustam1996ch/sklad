<?php

namespace sklad\controllers;

use sklad\models\search\DebtSearch;
use sklad\models\search\ProfitSearch;
use Yii;
use sklad\models\Receipt;
use sklad\models\search\ReceiptSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * ReceiptController implements the CRUD actions for Receipt model.
 */
class ReceiptController extends Controller
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
                        'actions' => ['foyda','qarz','otchot','ostatok','receipt-status','save','create','view','index','update','delete'],
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
     * Lists all Receipt models.
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        $searchModel = new ReceiptSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Receipt();

        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $pId = Yii::$app->request->post('editableKey');
            $model = Receipt::findOne($pId);

            // store a default json response as desired by editable
            $out = Json::encode(['output' => '', 'message' => '']);

            $post = [];
            $posted = current($_POST['Receipt']);
            $post['Receipt'] = $posted;

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';


                if (isset($posted['status'])) {
                    $output = $model->status; // process as you need
                }
                $out = Json::encode(['output' => $output, 'message' => '']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'id' => $id,
        ]);
    }

    /**
     * Lists all Packet models.
     * @return mixed
     */
    public function actionNotConfirmed($id = null)
    {
        $searchModel = new ReceiptSearch();
        $searchModel->notConfirmed = true;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('not-confirmed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
        ]);
    }

    public function actionStatusUpdate(){

        $id = $_POST['editableKey'];
        $editableIndex = $_POST['editableIndex'];
        $sellStatus = $_POST['Receipt'];
        $v = $sellStatus[$editableIndex]['status'];
        $model = $this->findModel($id);
        $model->status = $v;
        $model->save(false);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return true;

    }

    /**
     * Displays a single Receipt model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Receipt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Receipt();

        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Receipt model.
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
            $model = new Receipt();
        } else {
            $model = $this->findModel($id);
        }

        $result = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result['success'] = 1;
            $result['view'] = $this->render('_form', ['model' => new Receipt()]);
        } else {
            $result['success'] = 0;
            $result['view'] = $this->render('_form', ['model' => $model]);
        }
        return $result;
    }

    /**
     * Deletes an existing Receipt model.
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
     * Finds the Receipt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Receipt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Receipt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionOstatok(){
        $this->layout = 'frest/main';
        return 'Bu ostatok uchun action';
    }

    public function actionOtchot(){
        return 'Bu Отчёт uchun action';
    }

    public function actionQarz(){
        $searchModel = new DebtSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('debt', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFoyda(){
        $searchModel = new ProfitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('profit', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
