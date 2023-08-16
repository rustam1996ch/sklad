<?php

//$items = [
//    ['label' => '<i class="bx bx-calendar"></i> Unit', 'url' => ['/unit/index']],
//    ['label' => '<i class="bx bx-calendar"></i> Menu 1', 'url' => ['/rbac/permission/index']],
//    ['label' => 'User Management',
//        'url' => ['/rbac/menu/index'],
//        'template' => '<a href="{url}" ><i class="bx bx-grid-alt"></i>{label}<i class="fa fa-angle-left pull-right"></i></a>',
//        'options' => ['class' => 'nav-item'],
//        'items' => [
//            ['label' => '<i class="bx bx-calendar"></i> Assignment', 'url' => ['/rbac/assignment/index']],
//            ['label' => '<i class="bx bx-calendar"></i> Role', 'url' => ['/rbac/role/index']],
//            ['label' => '<i class="bx bx-calendar"></i> Permission', 'url' => ['/rbac/permission/index']],
//            ['label' => '<i class="bx bx-calendar"></i> Route', 'url' => ['/rbac/route/index']],
//            ['label' => '<i class="bx bx-calendar"></i> Menu', 'url' => ['/rbac/menu/index']],
//        ],
//    ],
//];

$roleName = app()->user->identity->role->name;

switch ($roleName) {

    case 'bugalter':

        //Бухгалтер
        $items = [
            ['label' => '<i class="bx bx-slideshow"></i> Приборная доска', 'url' => ['/']],
            ['label' => '<i class="bx bx-cube"></i> Поддоны', 'url' => ['/packet/index']],
            ['label' => '<i class="bx bx-user-plus"></i> Клиенты', 'url' => ['/client/index']],
            ['label' => '<i class="bx bx-no-entry"></i> Не подтверждено', 'url' => ['/sell/not-confirmed','type'=>0]],
            ['label' => '<i class="bx bx-badge-check"></i> Отгрузки', 'url' => ['/sell/index']],
            ['label' => '<i class="bx bx-money"></i> Оплата', 'url' => ['/payment/index']],
            ['label' => '<i class="bx bx-bar-chart-alt-2"></i> Склад Остаток', 'url' => ['/rasxod/ostatok-product']],
            ['label' => '<i class="bx bxl-unsplash"></i> Поддон Остаток', 'url' => ['/buffer/ostatok-product']],
            ['label' => '<i class="bx bx-calendar-event"></i> Склад остаток день', 'url' => ['/rasxod/ostatok-days2']],
            ['label' => '<i class="bx bx-briefcase-alt-2"></i> Дебет Кредит', 'url' => ['/receipt/qarz']],
//            ['label' => '<i class="bx bxs-pie-chart-alt-2"></i> Прибыль', 'url' => ['/receipt/foyda']],
            ['label' => '<i class="bx bxs-data"></i> Товары', 'url' => ['/product/index']],
            ['label' => '<i class="bx bx-doughnut-chart"></i> Категории товаров', 'url' => ['/product-type/index']],
            ['label' => '<i class="bx bx-bar-chart-square"></i> Ед. изм.', 'url' => ['/unit/index']],
            ['label' => '<i class="bx bxs-group"></i> Пользователи', 'url' => ['/user/index']],
        ];
        break;

    case 'sklad':

        //Склад
        $items = [
            ['label' => '<i class="bx bx-user-plus"></i> Приход', 'url' => ['/receipt/index']],
            ['label' => '<i class="bx bx-block"></i> Не проверенные', 'url' => ['/receipt/not-confirmed']],
            ['label' => '<i class="bx bx-cube"></i> Поддоны', 'url' => ['/packet/index']],
            ['label' => '<i class="bx bx-badge-check"></i> Отгрузки', 'url' => ['/sell/index']],
            ['label' => '<i class="bx bx-bar-chart-alt-2"></i> Склад Остаток', 'url' => ['/rasxod/ostatok-product']],
            ['label' => '<i class="bx bxl-unsplash"></i> Поддон Остаток', 'url' => ['/buffer/ostatok-product']],
            ['label' => '<i class="bx bxs-data"></i> Товары', 'url' => ['/product/index']],
            ['label' => '<i class="bx bx-doughnut-chart"></i> Категории товаров', 'url' => ['/product-type/index']],
            ['label' => '<i class="bx bx-right-arrow-circle"></i> Получить из поддон', 'url' => ['/gave-buffer-receipt/index']],
            ['label' => '<i class="bx bx-calendar-event"></i> Склад остаток день', 'url' => ['/rasxod/ostatok-days2']],
            ['label' => '<i class="bx bxs-group"></i> Пользователи', 'url' => ['/user/index']],
        ];

        break;

    case 'buffer':

        //Буффер
        $items = [
            ['label' => '<i class="bx bx-block"></i> Не проверенные', 'url' => ['/receipt/not-confirmed']],
            ['label' => '<i class="bx bx-cube"></i> Поддоны', 'url' => ['/packet/index']],
            ['label' => '<i class="bx bxs-data"></i> Товары', 'url' => ['/product/index']],
            ['label' => '<i class="bx bxl-unsplash"></i> Поддон Остаток', 'url' => ['/buffer/ostatok-product']],
            ['label' => '<i class="bx bx-left-arrow-circle"></i> Давать Складу', 'url' => ['/gave-buffer-receipt/index']],
            ['label' => '<i class="bx bxs-group"></i> Пользователи', 'url' => ['/user/index']],
        ];
        break;

    case 'rahbar':

        //Раҳбар
        $items = [
            ['label' => '<i class="bx bx-bar-chart-alt-2"></i> Склад Остаток', 'url' => ['/rasxod/ostatok-product']],
            ['label' => '<i class="bx bx-calendar-event"></i> Склад остаток день', 'url' => ['/rasxod/ostatok-days2']],
            ['label' => '<i class="bx bx-cube"></i> Поддоны', 'url' => ['/packet/index']],
            ['label' => '<i class="bx bx-slideshow"></i> Приборная доска', 'url' => ['/']],
//            ['label' => '<i class="bx bxs-pie-chart-alt-2"></i> Прибыль', 'url' => ['/receipt/foyda']],
            ['label' => '<i class="bx bxs-data"></i> Товары', 'url' => ['/product/index']],
            ['label' => '<i class="bx bx-briefcase-alt-2"></i> Дебет Кредит', 'url' => ['/receipt/qarz']],
            ['label' => '<i class="bx bxl-unsplash"></i> Поддон Остаток', 'url' => ['/buffer/ostatok-product']],
            ['label' => '<i class="bx bxs-group"></i> Пользователи', 'url' => ['/user/index']],
        ];
        break;
    case 'oxrana':

        //oxrana
        $items = [
            ['label' => '<i class="bx bx-car"></i> Список автомобилей', 'url' => ['/sell/cars']],
        ];
        break;

    case 'admin':

        //admin
        $items = [
            ['label' => '<i class="bx bx-slideshow"></i> Приборная доска', 'url' => ['/']],
            ['label' => '<i class="bx bx-cube"></i> Поддоны', 'url' => ['/packet/index']],
            ['label' => '<i class="bx bx-user-plus"></i> Клиенты', 'url' => ['/client/index']],
            ['label' => '<i class="bx bx-no-entry"></i> Не подтверждено', 'url' => ['/sell/not-confirmed','type'=>0]],
            ['label' => '<i class="bx bx-badge-check"></i> Отгрузки', 'url' => ['/sell/index']],
            ['label' => '<i class="bx bx-money"></i> Оплата', 'url' => ['/payment/index']],
            ['label' => '<i class="bx bx-bar-chart-alt-2"></i> Склад Остаток', 'url' => ['/rasxod/ostatok-product']],
            ['label' => '<i class="bx bxl-unsplash"></i> Поддон Остаток', 'url' => ['/buffer/ostatok-product']],
            ['label' => '<i class="bx bx-calendar-event"></i> Склад остаток день', 'url' => ['/rasxod/ostatok-days2']],
            ['label' => '<i class="bx bx-briefcase-alt-2"></i> Дебет Кредит', 'url' => ['/receipt/qarz']],
//            ['label' => '<i class="bx bxs-pie-chart-alt-2"></i> Прибыль', 'url' => ['/receipt/foyda']],
            ['label' => '<i class="bx bxs-data"></i> Товары', 'url' => ['/product/index']],
            ['label' => '<i class="bx bx-doughnut-chart"></i> Категории товаров', 'url' => ['/product-type/index']],
            ['label' => '<i class="bx bx-bar-chart-square"></i> Ед. изм.', 'url' => ['/unit/index']],
            ['label' => '<i class="bx bxs-group"></i> Пользователи', 'url' => ['/user/index']],
            ['label' => '<i class="bx bx-block"></i> Не проверенные', 'url' => ['/receipt/not-confirmed']],
            ['label' => '<i class="bx bx-car"></i> Список автомобилей', 'url' => ['/sell/cars']],
            ['label' => 'Управление',
                'url' => ['/'],
                'template' => '<a href="{url}" ><i class="fas fa-user-cog"></i>{label}</a>',
                'options' => ['class' => 'nav-item has-sub'],
                'items' => [
                    ['label' => '<i class="bx bxl-git"></i> Соед', 'url' => ['/connertor/index']],
                    ['label' => '<i class="bx bxl-redux"></i> Тип гофры', 'url' => ['/gofra/index']],
                    ['label' => '<i class="bx bxl-500px"></i> Слой', 'url' => ['/layer/index']],
                    ['label' => '<i class="bx bxs-map"></i> Территория', 'url' => ['/territory/index']],
                ]
            ],
        ];
        break;

    default:
        $items = [];
}

?>
<!-- NAVIGATION - MENU -->
<div data-scroll-to-active="true" class="main-menu menu-fixed menu-light menu-accordion menu-shadow">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="<?= bu() ?>">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">Master Pack</h2>
                </a></li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" id="menu-left" data-toggle="collapse">
                    <i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                    <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                       data-ticon="bx-disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <?= \yii\widgets\Menu::widget([
            'options' => ['class' => 'navigation navigation-main treeview', 'id' => 'main-menu-navigation'],
//            'linkTemplate' => '<li class="nav-item"><a href="{url}">{label}</a></li>',
//            'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id),
//            'items' => \mdm\admin\components\Helper::filter($items),
            'items' => $items,
            'submenuTemplate' => "\n<ul class='menu-content'>\n{items}\n</ul>\n",
            'encodeLabels' => false, //allows you to use html in labels
            'activateParents' => true,]); ?>
    </div>
</div>
<?php
$this->registerJs(<<<JS
        $("#menu-left").click(function(e){
            let menu_lefts = 1;
            if (menu_lefts){
                $.ajax({
                    url:window.baseUrl+'site/menu-left',
                    type: 'POST',
                    data:{
                      menu_lefts: menu_lefts
                    },
                    success: function(response) {
                    }
                })
            }else{

            }

        });
JS
);
?>
