<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Payment */

$this->title = 'Оплата: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Оплатаи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="payment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
