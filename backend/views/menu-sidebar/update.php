<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MenuSidebar */

$this->title = 'Menu Sidebar: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menu Sidebarи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="menu-sidebar-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
