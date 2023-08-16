<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Unit */

$this->title = 'Единица Измерения: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Единица Измерения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="unit-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
