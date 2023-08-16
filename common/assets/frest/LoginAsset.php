<?php

namespace common\assets\frest;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/frest/app-assets/css/bootstrap.css',
       'themes/frest/app-assets/css/bootstrap-extended.css',
       // 'themes/frest/app-assets/css/colors.css',
        'themes/frest/app-assets/css/components.css',
       // 'themes/frest/app-assets/css/themes/semi-dark-layout.css',
    ];

    public $js = [
    ];

    public $depends = [
        'common\assets\frest\VendorsAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
