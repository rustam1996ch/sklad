<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use sklad\models\Packet;
use sklad\models\Product;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model sklad\models\Receipt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receipt-form">

        <?php $form = ActiveForm::begin(['id' => 'save-receipt', 'action' => yii\helpers\Url::to(['receipt/save', 'id' => $model->id]), 'method' => 'post']); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'product_id')->widget(Select2::className(), [
                    'data' => $model->getProductList(),
                    'options' => ['placeholder' => 'Выберите продукт ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])?>
            </div>
            <div class="col-md-4">
            <?= $form->field($model, 'packet_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map(Packet::find()->all(), 'id', 'note'),
                        'options' => ['placeholder' => 'Выберите продукт ...'],
                        'pluginOptions' => [
                    'allowClear' => true
                ],
            ])?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'amount')->textInput(['class'=>'form-control input-transparent']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                 <?= $form->field($model, 'cost')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату ...'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
            </div>

        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-receipt-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>