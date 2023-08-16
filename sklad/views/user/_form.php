<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'save-user', 'action' => yii\helpers\Url::to(['user/save', 'id' => $model->id]), 'method' => 'post']); ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role_id')->widget(\kartik\select2\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\sklad\models\Role::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Выберите ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $model->isNewRecord ? $form->field($model, 'password_hash')->textInput(['maxlength' => true]) : $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['id' => 'save-user-form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
