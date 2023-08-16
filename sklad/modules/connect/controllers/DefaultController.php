<?php

namespace app\modules\connect\controllers;

use hr\modules\connect\components\Api;
use yii\web\Controller;
use yii\httpclient\Client;

/**
 * Default controller for the `connect` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetDevices()
    {

        $api = new Api();
        $connected = $api->auth();

        if ($connected) {

            $devices = $api->getDevices();
            prd($devices);
            die;

//            $url = \Yii::$app->params['connectUrl'] . 'admin/API/tree/devices';
//
//            $client = new Client();
//            $response = $client->createRequest()
//                ->setMethod('POST')
//                ->setUrl($url)
//                ->setFormat(Client::FORMAT_JSON)
//                ->setData([
//                    "orgCode" => "",
//                    "deviceCodes" => [],
//                    "categories" => []
//                ])
//                ->addHeaders(['X-Subject-Token' => $auth->token])
//                ->setOptions([
//                    'sslVerifyPeer' => false,
//                    'sslVerifyHost' => false,
//                ])
//                ->send();
//
//
//            if ($response->isOk) {
//
//                print_r($response->content);
//            }
        }

    }

    public function actionGetDevice($code){
        $api = new Api();
        $connected = $api->auth();

        if ($connected) {

            $devices = $api->getDevice($code);
            prd($devices);
            die;
        }

    }

    public function actionRecognitions(){
        $api = new Api();
        $connected = $api->auth();

        if ($connected) {

            $devices = $api->recognitions();
            prd($devices);
            die;
        }

    }

    public function actionReportDay(){
        $api = new Api();
        $connected = $api->auth();

        if ($connected) {

            $devices = $api->reportDay();
            prd($devices);
            die;
        }

    }

    public function actionPersonTypes(){
        $api = new Api();
        $connected = $api->auth();

        if ($connected) {

            $devices = $api->getPersonTypes();
            prd($devices);
            die;
        }

    }
}
