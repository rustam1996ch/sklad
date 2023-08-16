<?php

use sklad\models\Client;
use sklad\models\ProductType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model sklad\models\ProductType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-type-form">

        <?php $form = ActiveForm::begin(['id' => 'save-product-type', 'action' => yii\helpers\Url::to(['product-type/save', 'id' => $model->id]), 'method' => 'post']); ?>

        <?= $form->field($model, 'client_id')->widget(\kartik\select2\Select2::class, [
                'data' => ArrayHelper::map(Client::find()->asArray()->all(),'id', 'name'),
        ]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>

        <?= $form->field($model, 'no')->textInput(['class'=>'form-control input-transparent', 'type' => 'number']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-product-type-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
