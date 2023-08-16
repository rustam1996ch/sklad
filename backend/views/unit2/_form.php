<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Unit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-form">


        <?php $form = ActiveForm::begin(['id' => 'save-unit2', 'action' => yii\helpers\Url::to(['unit2/save', 'id' => $model->id]), 'method' => 'post']); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-unit2-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>


</div>
