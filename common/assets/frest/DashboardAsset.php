<?php


namespace common\assets\frest;

use yii\web\AssetBundle;

class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/frest/app-assets/vendors/css/vendors.min.css',
        'themes/frest/app-assets/vendors/css/tables/datatable/datatables.min.css',

        'themes/frest/app-assets/vendors/css/vendors.min.css',
        'themes/frest/app-assets/vendors/css/charts/apexcharts.css',
        'themes/frest/app-assets/vendors/css/extensions/swiper.min.css',

        'themes/frest/app-assets/css/bootstrap.css',
        'themes/frest/app-assets/css/bootstrap-extended.css',
        'themes/frest/app-assets/css/colors.css',
        'themes/frest/app-assets/css/components.css',
        'themes/frest/app-assets/css/themes/dark-layout.css',
        'themes/frest/app-assets/css/themes/semi-dark-layout.css',

        'themes/frest/app-assets/css/core/menu/menu-types/vertical-menu.css',
        'themes/frest/app-assets/css/pages/dashboard-ecommerce.css',

        'themes/frest/assets/css/style.css',
    ];

    public $js = [
        'themes/frest/app-assets/vendors/js/vendors.min.js',
        'themes/frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js',
        'themes/frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js',
        'themes/frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js',
        'themes/frest/app-assets/vendors/js/charts/apexcharts.min.js',
        'themes/frest/app-assets/vendors/js/extensions/swiper.min.js',
        'themes/frest/app-assets/js/scripts/configs/vertical-menu-light.js',
        'themes/frest/app-assets/js/core/app-menu.js',
        'themes/frest/app-assets/js/core/app.js',
        'themes/frest/app-assets/js/scripts/components.js',
        'themes/frest/app-assets/js/scripts/footer.js',
        'themes/frest/app-assets/js/scripts/pages/dashboard-ecommerce.js',
    ];

    public $depends = [
        'sklad\assets\HeadAsset',
        'common\assets\frest\VendorsAsset',
        'yii\bootstrap4\BootstrapAsset',
        'rmrevin\yii\fontawesome\CdnFreeAssetBundle',
    ];
}