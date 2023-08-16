<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Territory */

$this->title = 'Territory: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Territoryи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="territory-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
