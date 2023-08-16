<?php

namespace common\assets\frest;

use yii\web\AssetBundle;

class VendorsAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/frest/app-assets/vendors';
    public $baseUrl = '@web/themes/frest/app-assets/vendors';
    public $css = [
        'css/vendors.min.css',
    ];

    public $js = [
        'js/vendors.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
