<?php

namespace sklad\controllers;

use sklad\models\Rasxod;
use sklad\models\search\OstatokDaysProductSearch;
use sklad\models\search\OstatokProductSearch;
use sklad\models\search\OstatokTotalSearch;
use sklad\models\search\RasxodSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * RasxodController implements the CRUD actions for Rasxod model.
 */
class RasxodController extends Controller
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
                        'actions' => ['ajax-ostatok-days', 'ostatok-days', 'ostatok-total', 'ostatok-product', 'save', 'create', 'view', 'index', 'update', 'delete'],
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

    public function actionIndex()
    {
        $searchModel = new RasxodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Rasxod();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
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
        $model = new Rasxod();

        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    public function actionOstatokProduct()
    {
        $searchModel = new OstatokProductSearch();
        $searchModel->date = date('Y-m-d');

        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);


        return $this->render('ostatok/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOstatokTotal()
    {
        $searchModel = new OstatokTotalSearch();
        $searchModel->date1 = date('Y') . '-' . date('m') . '-' . '01';
        $searchModel->date2 = date('Y-m-d');

        $params = Yii::$app->request->queryParams;
        if (isset($params['OstatokTotalSearch']['date']) && $params['OstatokTotalSearch']['date']) {
            $params['OstatokTotalSearch']['date1'] = preg_replace('/(\d{2}).(\d{2}).(\d{1,4}) - (\d{2}).(\d{2}).(\d{1,4})/', '$3-$2-$1', $params['OstatokTotalSearch']['date']);
            $params['OstatokTotalSearch']['date2'] = preg_replace('/(\d{2}).(\d{2}).(\d{1,4}) - (\d{2}).(\d{2}).(\d{1,4})/', '$6-$5-$4', $params['OstatokTotalSearch']['date']);
        }
        $dataProvider = $searchModel->search($params);


        return $this->render('ostatok/total', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
            $model = new Rasxod();
        } else {
            $model = $this->findModel($id);
        }

        $result = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result['success'] = 1;
            $result['view'] = $this->render('_form', ['model' => new Rasxod()]);
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
        if (($model = Rasxod::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionOstatokDays()
    {
        $searchModel = new OstatokDaysProductSearch();

        $searchModel->date1 = date('Y') . '-' . date('m') . '-' . '01';
        $searchModel->date2 = date('Y-m-d');
        $searchModel->date = '01' . '.' . date('m') . '.' . date('Y') . ' - ' . date('d.m.Y');

        $params = Yii::$app->request->queryParams;

        $days = $searchModel->search($params);

        return $this->render('ostatok/days', [
            'searchModel' => $searchModel,
            'days' => $days,
        ]);
    }


    public function actionOstatokDays2()
    {
        $searchModel = new OstatokDaysProductSearch();

        $searchModel->date1 = date('Y') . '-' . date('m') . '-' . '01';
        $searchModel->date2 = date('Y-m-d');

        $params = Yii::$app->request->queryParams;

        $rows = $searchModel->search2($params);

        $searchModel->date = $searchModel->date1 . ' - ' . $searchModel->date2;

        return $this->render('ostatok/days', [
            'searchModel' => $searchModel,
            'rows' => $rows,
        ]);
    }

    public function actionAjaxOstatokDays()
    {
        if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
        } else {
            $startDate = date('Y') . '-' . date('m') . '-' . '01';
            $endDate = date('Y-m-d');
        }
        $skipEmpties = (int)$_GET['skipEmpties'];

        $searchModel = new OstatokDaysProductSearch();
        $searchModel->date1 = $startDate;
        $searchModel->date2 = $endDate;
        $searchModel->skipEmpties = $skipEmpties;
        $params = Yii::$app->request->queryParams;
        $rows = $searchModel->search2($params);
        Yii::$app->response->format = Response::FORMAT_JSON;
//        return $res;
        return $this->renderAjax('ostatok/days-table', [
            'rows' => $rows,
        ]);
    }

}
