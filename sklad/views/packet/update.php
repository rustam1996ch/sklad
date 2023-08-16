<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Packet */

$this->title = 'Поддон: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Поддоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="packet-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
