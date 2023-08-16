<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model sklad\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

        <?php $form = ActiveForm::begin(['id' => 'save-client', 'action' => yii\helpers\Url::to(['client/save', 'id' => $model->id]), 'method' => 'post']); ?>

       
        	<div class="row">
        		<div class="col-md-4">
        			 <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        		<div class="col-md-4">
        			 <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        		<div class="col-md-4">
        			 <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4">
        			 <?= $form->field($model, 'h_raqam')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        		<div class="col-md-4">
        			 <?= $form->field($model, 'bank')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        		<div class="col-md-4">
        			 <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4">
        			 <?= $form->field($model, 'mfo')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        		<div class="col-md-4">
        			 <?= $form->field($model, 'inn')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        		<div class="col-md-4">
        			 <?= $form->field($model, 'okonx')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4">
        			 <?= $form->field($model, 'director')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        		<div class="col-md-4">
        			 <?= $form->field($model, 'basis')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
        		</div>
        	
        	</div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-client-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>


</div>
