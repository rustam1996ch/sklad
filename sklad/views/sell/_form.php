<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model sklad\models\Sell */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sell-form">


        <?php $form = ActiveForm::begin(['id' => 'save-sell', 'action' => yii\helpers\Url::to(['sell/save', 'id' => $model->id]), 'method' => 'post']); ?>

        <?= $form->field($model, 'date')->textInput(['class'=>'form-control input-transparent']) ?>

        <?= $form->field($model, 'car_number')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>

        <?= $form->field($model, 'note')->textarea(['rows' => 6, 'class'=>'form-control input-transparent']) ?>

        <?= $form->field($model, 'client_id')->textInput(['class'=>'form-control input-transparent']) ?>

        <?= $form->field($model, 'status')->textInput(['class'=>'form-control input-transparent']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-sell-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>


</div>
