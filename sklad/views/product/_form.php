<?php

use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use sklad\models\Client;
use sklad\models\Connertor;
use sklad\models\Gofra;
use sklad\models\Layer;
use sklad\models\Territory;
use sklad\models\Unit;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model sklad\models\Product */
/* @var $form yii\widgets\ActiveForm */

$productTypeData = [];

if ($model->product_type_id) {
    $model->client_id = $model->productType->client_id;

    $productTypeData = [$model->product_type_id => $model->productType->name];
}
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['id' => 'save-product', 'action' => yii\helpers\Url::to(['product/save', 'id' => $model->id]), 'method' => 'post']); ?>
    <div class="row">

        <div class="col-md-4">
            <?= $form->field($model, 'client_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(Client::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'product_type_id')->widget(DepDrop::className(), [
                'data' => [],
                'options' => [
                    'class' => 'form-control input-transparent',
                ],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                'pluginOptions' => [
                    'depends' => ['product-client_id'],
                    'placeholder' => false,
                    'initialize' => true,
                    'url' => Url::to(['/product-type/get-list-by-client'])
                ],
//                'options' => ['placeholder' => 'Выберите ...'],
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'territory_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(Territory::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>

    </div>

    <div class="row">

        <div class="col-md-2">
            <label class="control-label" for="product-vendor_code" id="product-vendor_code-label">АРТИКУЛ (<?= \sklad\models\Product::find()->orderBy(['id' => SORT_DESC])->one()->vendor_code ?>)</label>
            <?= $form->field($model, 'vendor_code')->textInput(['maxlength' => true, 'class' => 'form-control input-transparent'])->label(false) ?>
        </div>

        <div class="col-md-10">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control input-transparent']) ?>
        </div>

    </div>

    <div class="row">

        <div class="col-md-2">
            <?= $form->field($model, 'x')->textInput(['type' => 'number', 'class' => 'form-control input-transparent']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'y')->textInput(['type' => 'number', 'class' => 'form-control input-transparent']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'z')->textInput(['type' => 'number', 'class' => 'form-control input-transparent']) ?>
        </div>

        <div class="col-md-2"></div>

        <div class="col-md-2">
            <?= $form->field($model, 'cost')->textInput(['type' => 'number', 'maxlength' => true, 'class' => 'form-control input-transparent']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'price')->textInput(['type' => 'number', 'maxlength' => true, 'class' => 'form-control input-transparent']) ?>
        </div>

    </div>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'a')->textInput(['type' => 'number', 'class' => 'form-control input-transparent'])->label('Длина заготовки (<small>мм</small>)') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'b')->textInput(['type' => 'number', 'class' => 'form-control input-transparent'])->label('Ширина заготов (<small>мм</small>)') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mkv')->textInput(['type' => 'number', 'class' => 'form-control input-transparent'])->label('Площадь заготовки (<small>м</small><sup>2</sup>)') ?>
        </div>


        <div class="col-md-3">
            <?= $form->field($model, 'fraction')->textInput(['type' => 'number', 'class' => 'form-control input-transparent']) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'weight_gofra')->textInput(['type' => 'number', 'maxlength' => true, 'class' => 'form-control input-transparent']) ?>
        </div>

    </div>

    <div class="row">


        <div class="col-md-2">
            <?= $form->field($model, 'mark')->textInput(['maxlength' => true, 'class' => 'form-control input-transparent']) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'layer1_id')->widget(Select2::className(), [
                'data' => ['' => ''] + ArrayHelper::map(Layer::find()->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'layer2_id')->widget(Select2::className(), [
                'data' => ['' => ''] + ArrayHelper::map(Layer::find()->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'layer3_id')->widget(Select2::className(), [
                'data' => ['' => ''] + ArrayHelper::map(Layer::find()->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'layer4_id')->widget(Select2::className(), [
                'data' => ['' => ''] + ArrayHelper::map(Layer::find()->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'layer5_id')->widget(Select2::className(), [
                'data' => ['' => ''] + ArrayHelper::map(Layer::find()->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-2">
            <?= $form->field($model, 'gofra1_id')->widget(Select2::className(), [
                'data' => ['' => ''] + ArrayHelper::map(Gofra::find()->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'gofra2_id')->widget(Select2::className(), [
                'data' => ['' => ''] + ArrayHelper::map(Gofra::find()->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'connertor_id')->widget(Select2::className(), [
                'data' => ['' => ''] + ArrayHelper::map(Connertor::find()->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'point_connector')->textInput(['type' => 'number', 'maxlength' => true, 'class' => 'form-control input-transparent']) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'amount_in_packet')->textInput(['type' => 'number', 'maxlength' => true, 'class' => 'form-control input-transparent']) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'unit_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(Unit::find()->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-product-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
