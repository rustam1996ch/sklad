<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Unit */

$this->title = 'Unit: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Unitи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="unit-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
