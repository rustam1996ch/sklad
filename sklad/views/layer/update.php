<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Layer */

$this->title = 'Layer: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Layerи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="layer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
