<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Sell */

$this->title = 'Продам: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Продам', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="sell-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
