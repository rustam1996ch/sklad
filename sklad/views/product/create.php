<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Product */

$this->title = 'Добавить Продукт';
$this->params['breadcrumbs'][] = ['label' => 'Продукти', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
