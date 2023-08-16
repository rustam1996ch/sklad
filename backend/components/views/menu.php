<?php
use yii\helpers\Html;
use yii\helpers\Url;

function menuTree($menu){
    $menu = new \common\models\MenuSidebar();
    $menu_sort_child = $menu->getMenusAsTree();
    prd($menu_sort_child);
    /*foreach ($menu_sort_child as $item){

    }*/


}

?>
<?= menuTree($menus); ?>

