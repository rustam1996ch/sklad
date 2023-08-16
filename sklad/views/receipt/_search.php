<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model sklad\models\search\ReceiptSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receipt-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'packet_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
