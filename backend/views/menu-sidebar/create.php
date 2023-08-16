<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MenuSidebar */

$this->title = 'Добавить menu Sidebar';
$this->params['breadcrumbs'][] = ['label' => 'Menu Sidebarи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-sidebar-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
