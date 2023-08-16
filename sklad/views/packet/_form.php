<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use sklad\models\Product;

/* @var $this yii\web\View */
/* @var $model sklad\models\Packet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="packet-form">

    <?php $form = ActiveForm::begin(['id' => 'save-packet', 'action' => yii\helpers\Url::to(['packet/save', 'id' => $model->id]), 'method' => 'post']); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'product_id')->widget(Select2::className(), [
                        'data' => $model->getProductList(),
                        'options' => ['placeholder' => 'Выберите продукт ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])?>
                </div>
                <div class="col-md-3">
                    <br>
                    <button type="button" id="product_model" class="btn btn-outline-success">
                        Информация
                    </button>
                </div>
                <div class="col-md-3">
                    <label class="control-label" for="packet-amount">КОЛИЧЕСТВО В поддоны</label>
                    <input type="number" id="productAmountInPacket"
                           data-product_id="<?= ($model->isNewRecord) ? '' : $model->product_id ?>"
                           class="form-control"
                           value="<?= ($model->isNewRecord) ? '' : $model->product->amount_in_packet ?>"
                           aria-required="true" aria-invalid="false">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'amount')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => '',
                    'value' => date("Y-m-d"),
                ],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList([1 => 'Актив', 0 => 'Неактив']) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'note')->textarea(['rows' => 3, 'class'=>'form-control input-transparent']) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-packet-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark white">
                    <h5 class="modal-title" id="exampleModalScrollableTitle" style="color: white;">Продукт информация</h5>
                </div>
                <div class="modal-body" id="product_information_table">
                </div>
            </div>
        </div>
    </div>


</div>
