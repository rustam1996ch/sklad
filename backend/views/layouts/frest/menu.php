<?php

use mdm\admin\components\MenuHelper;

$items = [
    ['label' => '<i class="bx bx-calendar"></i> Menu', 'url' => ['/menu-sidebar/index']],
    ['label' => '<i class="bx bx-calendar"></i> Unit', 'url' => ['/unit/index']],
    ['label' => '<i class="bx bx-calendar"></i> Menu 1', 'url' => ['/rbac/permission/index']],
    ['label' => 'User Management',
        'url' => ['/rbac/menu/index'],
        'template' => '<a href="{url}" ><i class="bx bx-grid-alt"></i>{label}<i class="fa fa-angle-left pull-right"></i></a>',
        'options' => ['class' => 'nav-item has-sub'],
        'items' => [
            ['label' => '<i class="bx bx-calendar"></i> Assignment', 'url' => ['/rbac/assignment/index']],
            ['label' => '<i class="bx bx-calendar"></i> Role', 'url' => ['/rbac/role/index']],
            ['label' => '<i class="bx bx-calendar"></i> Permission', 'url' => ['/rbac/permission/index']],
            ['label' => '<i class="bx bx-calendar"></i> Route', 'url' => ['/rbac/route/index']],
            ['label' => '<i class="bx bx-calendar"></i> Menu', 'url' => ['/rbac/menu/index']],
        ],
    ],
    ['label' => 'Miscellaneous',
        'url' => ['/rbac/menu/index'],
        'template' => '<a href="{url}" ><i class="bx bx-grid-alt"></i>{label}</a>',
        'options' => ['class' => 'nav-item has-sub'],
        'items' => [
            ['label' => '<i class="bx bx-calendar"></i> Coming Soon', 'url' => ['/rbac/assignment/index']],
            ['label' => 'Error',
                'url' => ['/rbac/menu/index'],
                'template' => '<a href="{url}" ><i class="bx bx-grid-alt"></i>{label}</a>',
                'options' => ['class' => 'nav-item'],
                'items' => [
                    ['label' => '<i class="bx bx-calendar"></i> 404', 'url' => ['/rbac/assignment/index']],
                    ['label' => '<i class="bx bx-calendar"></i> 500', 'url' => ['/rbac/role/index']],
                ],
            ],
            ['label' => '<i class="bx bx-calendar"></i> Not Authorized', 'url' => ['/rbac/permission/index']],
        ],
    ],
];

?>
<?php //echo \backend\components\Menu::widget(); ?>
<!-- NAVIGATION - MENU -->
<div data-scroll-to-active="true" class="main-menu menu-fixed menu-light menu-accordion menu-shadow">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="<?=bu()?>">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">Frest</h2>
                </a></li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" id="menu-left" data-toggle="collapse">
                    <i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                    <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="bx-disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <?=\yii\widgets\Menu::widget([
            'options' => ['class' => 'navigation navigation-main treeview', 'id' => 'main-menu-navigation'],
            'linkTemplate' => '<li class="nav-item"><a href="{url}">{label}</a></li>',
//            'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id),
//            'items' => \mdm\admin\components\Helper::filter($items),
            'items' => $items,
            'submenuTemplate' => "\n<ul class='menu-content'>\n{items}\n</ul>\n",
            'encodeLabels' => false, //allows you to use html in labels
            'activateParents' => true,   ]);  ?>
    </div>
</div
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
