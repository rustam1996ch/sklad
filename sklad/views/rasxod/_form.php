<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use sklad\models\Product;
use sklad\models\Packet;
use sklad\models\Sell;

/* @var $this yii\web\View */
/* @var $model sklad\models\Rasxod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rasxod-form">


        <?php $form = ActiveForm::begin(['id' => 'save-rasxod', 'action' => yii\helpers\Url::to(['rasxod/save', 'id' => $model->id]), 'method' => 'post']); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'product_id')->dropDownList(ArrayHelper::map(Product::find()->all(), 'id', 'name')) ?>
            <?php $form->field($model, 'product_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(Product::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите продукт ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'packet_id')->dropDownList(ArrayHelper::map(Packet::find()->all(), 'id', 'note')) ?>
            <?php $form->field($model, 'packet_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(Packet::find()->all(), 'id', 'note'),
                'options' => ['placeholder' => 'Выберите продукт ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sell_id')->dropDownList(ArrayHelper::map(Sell::find()->all(), 'id', 'note')) ?>
            <?php $form->field($model, 'sell_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(Sell::find()->all(), 'id', 'note'),
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'cost')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent', 'type' => 'number']) ?>
            <?= $form->field($model, 'amount')->textInput(['type' => 'integer', 'maxlength' => true, 'class'=>'form-control input-transparent', 'type' => 'number']) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату ...'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
            <?= $form->field($model, 'status')->dropDownList([1 => 'Актив', 0 => 'Неактив']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'note')->textarea(['rows' => 5, 'class'=>'form-control input-transparent']) ?>
        </div>
    </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-rasxod-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>


</div>
