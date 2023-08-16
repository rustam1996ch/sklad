<?php

namespace backend\assets\frest;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/frest/app-assets/css/bootstrap.css',
        'themes/frest/app-assets/css/bootstrap-extended.css',
        'themes/frest/app-assets/css/colors.css',
        'themes/frest/app-assets/css/components.css',
        'themes/frest/app-assets/css/themes/dark-layout.css',
        'themes/frest/app-assets/css/themes/semi-dark-layout.css',

        'themes/frest/app-assets/css/core/menu/menu-types/vertical-menu.css',
        'themes/frest/app-assets/css/pages/dashboard-analytics.css',

        // Custom Css
        'themes/frest/assets/css/style.css',
    ];

    public $js = [
        'themes/frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js',
        'themes/frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js',
        'themes/frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js',

        'themes/frest/app-assets/vendors/js/charts/apexcharts.min.js',
        'themes/frest/app-assets/vendors/js/extensions/dragula.min.js',

        'themes/frest/app-assets/js/core/app-menu.js',
        'themes/frest/app-assets/js/core/app.js',
        'themes/frest/app-assets/js/scripts/components.js',
        'themes/frest/app-assets/js/scripts/footer.js',

        'themes/frest/app-assets/js/scripts/pages/dashboard-analytics.js',
        'themes/frest/app-assets/js/scripts/customizer.min.js',

        'themes/frest/assets/js/scripts.js'
    ];

    public $depends = [
        'backend\assets\frest\VendorsAsset',
        'yii\bootstrap4\BootstrapAsset',
        'rmrevin\yii\fontawesome\CdnFreeAssetBundle',
    ];
}
