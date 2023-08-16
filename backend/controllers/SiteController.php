<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error', 'logout', 'index', 'menu-left', 'dark', 'light'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['deny', 'seny','under'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'menu-left'){
            $this->enableCsrfValidation = false;
        }elseif ($action->id == 'deny'|| $action->id=='seny'||$action->id=='under') {
            $this->layout = 'frest/login';
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'frest/login',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'frest/login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionMenuLeft()
    {
        $res = $_POST['menu_lefts'];
        $session = Yii::$app->session;
        if ($session->get('menu_left') == 0) {
            $session = Yii::$app->session;
            $session->set('menu_left', 1);
        } else {
            $session = Yii::$app->session;
            $session->set('menu_left', 0);
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $res;
    }

    public function actionDark()
    {
        $res = 0;
        $session = Yii::$app->session;
        if ($session->get('menu_dark') == 0) {
            $session = Yii::$app->session;
            $session->set('menu_dark', 1);
            $res =1;
        } else {
            $session = Yii::$app->session;
            $session->set('menu_dark', 0);
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $res;
    }

    public function actionDeny()
    {
        return $this->render('403');
    }
    public function actionSeny()
    {
        return $this->render('500');
    }

    public function actionUnder()
    {
        return $this->render('under');
    }

        //   public function actionLight()
    // {
    //     $session = Yii::$app->session;
    //     if($session->get('menu_light') == 0 )
    //     {
    //         $session = Yii::$app->session;
    //         $session->set('menu_light', 1);
    //     }
    //     else{
    //         $session = Yii::$app->session;
    //         $session->set('menu_light', 0);
    //     }
    //     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //     return $res;
    // }
}
