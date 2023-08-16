<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Gofra */

$this->title = 'Gofra: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Gofraи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="gofra-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
