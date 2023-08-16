<?php

namespace backend\controllers;

use Yii;
use common\models\MenuSidebar;
use backend\models\MenuSidebarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * MenuSidebarController implements the CRUD actions for MenuSidebar model.
 */
class MenuSidebarController extends Controller
{

    public function behaviors()
    {
        return [
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
        $searchModel = new MenuSidebarSearch();
        $params = Yii::$app->request->queryParams;
        $params['MenuSidebarSearch']['parent_id'] = 0;

        $dataProvider = $searchModel->search($params);

        // validate if there is a editable input saved via AJAX
        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $pId = Yii::$app->request->post('editableKey');
            $model = MenuSidebar::findOne($pId);

            // store a default json response as desired by editable
            $out = Json::encode(['output' => '', 'message' => '']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['MenuSidebar']);
            $post['MenuSidebar'] = $posted;

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
//                if (isset($posted['c_order'])) {
//                    $output = Yii::$app->formatter->asDecimal($model->buy_amount, 2);
//                }

                // similarly you can check if the name attribute was posted as well
                if (isset($posted['page_id'])) {
                    if($model->page_id){
                        $output = $model->page->name_uz; // process as you need
                    }  else {
                        $output = null; // process as you need
                    }
                }
                if (isset($posted['link'])) {
                    if($model->link){
                        $output = $model->link; // process as you need
                    }  else {
                        $output = null; // process as you need
                    }
                }
                if (isset($posted['status'])) {
                    $output = $model->status; // process as you need
                }
                if (isset($posted['target_blank'])) {
                    $output = $model->target_blank; // process as you need
                }
                if (isset($posted['visible_top'])) {
                    $output = $model->visible_top; // process as you need
                }
                if (isset($posted['visible_side'])) {
                    $output = $model->visible_side; // process as you need
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
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($parent_id = 0)
    {
        $model = new MenuSidebar();
        $model->parent_id = $parent_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = MenuSidebar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDetail()
    {
        if(isset($_POST['editableKey'])){
            $parent_id = $_POST['editableKey'];
        }elseif($_POST['expandRowKey']){
            $parent_id = $_POST['expandRowKey'];
        }

        // validate if there is a editable input saved via AJAX
        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $pId = Yii::$app->request->post('editableKey');
            $model = MenuSidebar::findOne($pId);

            // store a default json response as desired by editable
            $out = Json::encode(['output' => '', 'message' => '']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['MenuSidebar']);
            $post['MenuSidebar'] = $posted;

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
//                if (isset($posted['c_order'])) {
//                    $output = Yii::$app->formatter->asDecimal($model->buy_amount, 2);
//                }

                // similarly you can check if the name attribute was posted as well

                if (isset($posted['link'])) {
                    if($model->link){
                        $output = $model->link; // process as you need
                    }  else {
                        $output = null; // process as you need
                    }
                }
                if (isset($posted['status'])) {
                    $output = $model->status; // process as you need
                }
                if (isset($posted['target_blank'])) {
                    $output = $model->target_blank; // process as you need
                }
                if (isset($posted['visible_top'])) {
                    $output = $model->visible_top; // process as you need
                }
                if (isset($posted['visible_side'])) {
                    $output = $model->visible_side; // process as you need
                }
                $out = Json::encode(['output' => $output, 'message' => '']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        $searchModel = new MenuSidebarSearch();

        $params = Yii::$app->request->queryParams;
        $params['MenuSidebarSearch']['parent_id'] = $parent_id;

        $dataProvider = $searchModel->search($params);

        return $this->renderAjax('detail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'parent_id' => $parent_id,
        ]);
    }

}
