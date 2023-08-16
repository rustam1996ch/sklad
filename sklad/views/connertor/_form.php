<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model sklad\models\Connertor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="connertor-form">


        <?php $form = ActiveForm::begin(['id' => 'save-connertor', 'action' => yii\helpers\Url::to(['connertor/save', 'id' => $model->id]), 'method' => 'post']); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-connertor-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>


</div>
