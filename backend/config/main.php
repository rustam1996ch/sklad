<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'layout' => 'frest/main',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
//                    'userClassName' => 'common\models\User',
                    'idField' => 'id',
                    'usernameField' => 'username',
                ],
            ],
        ],
        'dynagrid'=> [
            'class'=>'\kartik\dynagrid\Module',
            // other module settings
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
            // your other grid module settings
            'i18n' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@kvgrid/messages',
                'forceTranslation' => true
            ]
        ],
//        'gridviewKrajee' =>  [
//            'class' => '\kartik\grid\Module',
//            // your other grid module settings
//        ]
    ],
    'components' => [
        'request' => [
            'enableCsrfValidation' => false, // keyin ko'ramiz.
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'loginUrl' => ['site/login'],
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'js' => [],
                    'css' => [],
                    'depends' => [
                        'backend\assets\frest\VendorsAsset',
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [],
                    'depends' => [
                        'backend\assets\frest\VendorsAsset',
                    ]
                ],
                'yii\web\JqueryAsset' => [
                    'js' => YII_ENV_DEV ? ['jquery.js'] : ['jquery.min.js'],
                ],
                'kartik\form\ActiveFormAsset' => [
                    'depends' => [
                        'backend\assets\frest\VendorsAsset',
                    ],
                ],
                'kartik\bs4dropdown\DropdownAsset' => [
                    'js' => [],
                    'css' => [],
                ],
            ]
        ],
//        'i18n' => [
//            'translations' => [
//                'app' => [
//                    'class' => 'yii\i18n\PhpMessageSource',
//                    'basePath' => '@app/messages',
//                ],
//                'kvgrid' => [
//                    'class' => 'yii\i18n\PhpMessageSource',
//                    'basePath' => '@app/messages',
//                ],
//            ],
//        ],
    ],
    'params' => $params,
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            '*', //for all actions
            'site/*',
        ]
    ],
];
