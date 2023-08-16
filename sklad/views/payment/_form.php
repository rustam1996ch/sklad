<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use sklad\models\Client;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model sklad\models\Payment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-form">

        <?php $form = ActiveForm::begin(['id' => 'save-payment', 'action' => yii\helpers\Url::to(['payment/save', 'id' => $model->id]), 'method' => 'post']); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'client_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(Client::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите Клиент ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату ...'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
            <?= $form->field($model, 'amount')->textInput(['maxlength' => true, 'class'=>'form-control input-transparent', 'type' => 'number']) ?>
        </div>
        <div class="col-md-7">
            <?= $form->field($model, 'note')->textarea(['rows' => 5, 'class'=>'form-control input-transparent']) ?>
        </div>
    </div>
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-payment-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php ActiveForm::end(); ?>


</div>
