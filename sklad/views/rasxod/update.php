<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sklad\models\Rasxod */

$this->title = 'Расход: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Расходи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="rasxod-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
