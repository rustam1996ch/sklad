<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Client */

$this->title = 'Клиент: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Клиент', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="client-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
