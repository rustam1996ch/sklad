<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model sklad\models\Territory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="territory-form">


        <?php $form = ActiveForm::begin(['id' => 'save-territory', 'action' => yii\helpers\Url::to(['territory/save', 'id' => $model->id]), 'method' => 'post']); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-territory-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>


</div>
