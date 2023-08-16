<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Product */

$this->title = 'Продукт: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Продукти', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
