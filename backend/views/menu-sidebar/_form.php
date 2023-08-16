<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MenuSidebar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-sidebar-form">
    
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>

        <?= $form->field($model, 'parent_id')->dropDownList([NULL=>NULL]+\common\models\MenuSidebar::all($model->id)) ?>

        <?= $form->field($model, 'icon_name')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>

        <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>

        <?= $form->field($model, 'c_order')->textInput(['class'=>'form-control input-transparent']) ?>

        <?= $form->field($model, 'status')->checkbox(['checked' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    
</div>
