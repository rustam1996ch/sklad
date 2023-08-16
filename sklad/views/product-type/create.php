<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\ProductType */

$this->title = 'Добавить Категории товаров';
$this->params['breadcrumbs'][] = ['label' => 'Категории товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
