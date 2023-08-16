<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Connertor */

$this->title = 'Connertor: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Connertorи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="connertor-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
