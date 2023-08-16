<?php

namespace sklad\controllers;

use common\models\LoginForm;
use sklad\models\Packet;
use sklad\models\Receipt;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;

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
                        'actions' => ['login', 'error', 'dark', 'menu-left'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'test-connect'],
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
        if ($action->id == 'menu-left') {
            $this->enableCsrfValidation = false;
        } elseif ($action->id == 'deny' || $action->id == 'seny' || $action->id == 'under') {
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
        if (Yii::$app->user->identity->role_id == 6) {
            return $this->redirect(url(['/sell/cars ']));
        }
        $bufferCount = Packet::find()->where(['space' => 0])->count();

        return $this->render('index',
            compact('bufferCount'));
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

    /*public function actionTestConnect()
    {

        $connect = new Auth();
        $connect->run();

        var_dump($connect->success);

        die;
    }*/

    public function actionDark()
    {
        $res = 0;
        $session = Yii::$app->session;
        if ($session->get('menu_dark') == 0) {
            $session = Yii::$app->session;
            $session->set('menu_dark', 1);
            $res = 1;
        } else {
            $session = Yii::$app->session;
            $session->set('menu_dark', 0);
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $res;
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

//    public function actionRole()
//    {
//        $bufer = Yii::$app->authManager->createRole('bufer');
//        $bufer->description = 'bufer';
//        Yii::$app->authManager->add($bufer);
//
//        $sklad = Yii::$app->authManager->createRole('sklad');
//        $sklad->description = 'sklad';
//        Yii::$app->authManager->add($sklad);
//
//        $buxgalter = Yii::$app->authManager->createRole('buxgalter');
//        $buxgalter->description = 'buxgalter';
//        Yii::$app->authManager->add($buxgalter);
//
//        $rahbar = Yii::$app->authManager->createRole('rahbar');
//        $rahbar->description = 'rahbar';
//        Yii::$app->authManager->add($rahbar);
//    return 454848865;
//
//    }

}
