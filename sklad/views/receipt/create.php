<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Receipt */

$this->title = 'Добавить расписка в получении';
$this->params['breadcrumbs'][] = ['label' => 'расписка в получении', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
