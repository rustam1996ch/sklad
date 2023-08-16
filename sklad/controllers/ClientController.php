<?php

namespace sklad\controllers;

use Yii;
use sklad\models\Client;
use sklad\models\search\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
                        'actions' => ['add','save','create','view','index','update','delete'],
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
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Client();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Client model.
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
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();

        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Client model.
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
            $model = new Client();
        } else {
            $model = $this->findModel($id);
        }

        $result = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result['success'] = 1;
            $result['view'] = $this->render('_form', ['model' => new Client()]);
        } else {
            $result['success'] = 0;
            $result['view'] = $this->render('_form', ['model' => $model]);
        }
        return $result;
    }

    /**
     * Deletes an existing Client model.
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
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionAdd(){

        $name = $_POST['name'];

        $model = new Client();
        $model->name = $name;
        $model->save();

        app()->response->format = Response::FORMAT_JSON;

        return ['success'=> true, 'id' => $model->id];
    }
}
