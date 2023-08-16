<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MenuSidebar */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menu Sidebarи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-sidebar-view">

        <p>
            <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'parent_id',
                'name',
                'icon_name',
                'link',
                'c_order',
                'status',
            ],
        ]) ?>

</div>
