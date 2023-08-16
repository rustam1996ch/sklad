<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\ProductType */

$this->title = 'Категория товара: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="product-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
