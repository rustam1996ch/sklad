<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Receipt */

$this->title = 'расписка в получении: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'расписка в получении', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="receipt-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
