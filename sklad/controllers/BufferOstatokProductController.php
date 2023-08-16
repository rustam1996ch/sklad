<?php


namespace sklad\controllers;

use Yii;
use yii\web\Controller;
use sklad\models\search\BufferOstatokProductSearch;


class BufferOstatokProductController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new BufferOstatokProductSearch();
        $searchModel->date1 = date('Y').'-'.date('m').'-'.'01';
        $searchModel->date2 = date('Y-m-d');

        $params = Yii::$app->request->queryParams;
        if (isset($params['BufferOstatokProductSearch']['date']) && $params['BufferOstatokProductSearch']['date']) {
            $params['BufferOstatokProductSearch']['date1'] = preg_replace('/(\d{2}).(\d{2}).(\d{1,4}) - (\d{2}).(\d{2}).(\d{1,4})/', '$3-$2-$1', $params['BufferOstatokProductSearch']['date']);
            $params['BufferOstatokProductSearch']['date2'] = preg_replace('/(\d{2}).(\d{2}).(\d{1,4}) - (\d{2}).(\d{2}).(\d{1,4})/', '$6-$5-$4', $params['BufferOstatokProductSearch']['date']);
        }
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}