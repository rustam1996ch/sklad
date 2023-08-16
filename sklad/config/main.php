<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'Master Pack',
    'language' => 'ru',
    'timeZone' => 'Asia/Tashkent',
    'layout' => 'frest/main',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'sklad\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'common\models\User',
                    'idField' => 'id',
                    'usernameField' => 'username',
                ],
            ],
            'layout' => '@app/views/layouts/frest/main'
        ],
        'connect' => [
            'class' => 'app\modules\connect\Module',
        ],
        'product-excel' => [
            'class' => 'sklad\modules\productexcel\Module',
        ],
        'telegram' => [
            'class' => 'app\modules\telegram\Module',
        ],
        'dynagrid'=>[
            'class'=>'\kartik\dynagrid\Module',
        // other settings (refer documentation)
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
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'month' => [
            'class' => 'sklad\components\Month',
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['site/login'],
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
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'js' => [],
                    'css' => [],
                    'depends' => [
                        'common\assets\frest\VendorsAsset',
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [],
                    'depends' => [
                        'common\assets\frest\VendorsAsset',
                    ]
                ],
                'yii\web\JqueryAsset' => [
                    'js' => YII_ENV_DEV ? ['jquery.js'] : ['jquery.min.js'],
                ],
                'kartik\form\ActiveFormAsset' => [
                    'depends' => [
                        'common\assets\frest\VendorsAsset',
                    ],
                ],
                'kartik\bs4dropdown\DropdownAsset' => [
                    'js' => [],
                    'css' => [],
                ],
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'defaultTimeZone' => 'Asia/Tashkent',
            'dateFormat' => 'php:d.m.Y',
            'timeFormat' => 'php:H:i:s',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
//            'numberFormatterOptions' => [
//                \NumberFormatter::MIN_FRACTION_DIGITS => 0,
//                \NumberFormatter::MAX_FRACTION_DIGITS => 0,
//            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
//    'as access' => [
//        'class' => 'mdm\admin\components\AccessControl',
//        'allowActions' => [
//            'site/*',
////            '*', //for all actions
////            'rbac/*',
////            'organization/*'
//        ]
//    ],
    'params' => $params,
];
