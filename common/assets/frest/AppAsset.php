<?php

namespace common\assets\frest;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/frest/app-assets/vendors/css/vendors.min.css',
        'themes/frest/app-assets/vendors/css/tables/datatable/datatables.min.css',

        'themes/frest/app-assets/css/bootstrap.css',
        'themes/frest/app-assets/css/bootstrap-extended.css',
        'themes/frest/app-assets/css/colors.css',
        'themes/frest/app-assets/css/components.css',
        'themes/frest/app-assets/css/themes/dark-layout.css',
        'themes/frest/app-assets/css/themes/semi-dark-layout.css',

        'themes/frest/app-assets/css/core/menu/menu-types/vertical-menu.css',
        'themes/frest/app-assets/css/pages/dashboard-analytics.css',
        'themes/frest/assets/css/style.css?version=3',
    ];

    public $js = [
        'themes/frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js',
        'themes/frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js',
        'themes/frest/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js',
        'themes/frest/app-assets/js/scripts/forms/select/form-select2.js',

        'themes/frest/app-assets/vendors/js/tables/datatable/datatables.min.js',
        'themes/frest/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js',
        'themes/frest/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js',
        'themes/frest/app-assets/vendors/js/tables/datatable/buttons.html5.min.js',
        'themes/frest/app-assets/vendors/js/tables/datatable/buttons.print.min.js',
        'themes/frest/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js',
        'themes/frest/app-assets/vendors/js/tables/datatable/pdfmake.min.js',
        'themes/frest/app-assets/vendors/js/tables/datatable/vfs_fonts.js',

        //'themes/frest/app-assets/vendors/js/charts/apexcharts.min.js',
        'themes/frest/app-assets/vendors/js/extensions/dragula.min.js',

        'themes/frest/app-assets/js/core/app-menu.js',
        'themes/frest/app-assets/js/core/app.js',
        'themes/frest/app-assets/js/scripts/components.js',
        'themes/frest/app-assets/js/scripts/footer.js',

        'themes/frest/app-assets/js/scripts/pages/dashboard-analytics.js',
        'themes/frest/app-assets/js/scripts/customizer.min.js',

        'themes/frest/assets/js/scripts.js',
        'themes/frest/table-to-excel-master/dist/tableToExcel.js', //Add Excel

        'themes/frest/app-assets/js/scripts/datatables/datatable.js',
//        'themes/frest/app-assets/js/scripts/pages/table-extended.js',
    ];

    public $depends = [
        'sklad\assets\HeadAsset',
        'common\assets\frest\VendorsAsset',
        'yii\bootstrap4\BootstrapAsset',
        'rmrevin\yii\fontawesome\CdnFreeAssetBundle',
    ];
}
