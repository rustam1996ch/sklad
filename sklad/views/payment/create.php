<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Payment */

$this->title = 'Добавить Оплата';
$this->params['breadcrumbs'][] = ['label' => 'Оплати', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
