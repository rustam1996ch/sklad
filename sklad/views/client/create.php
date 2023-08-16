<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Client */

$this->title = 'Добавить Клиент';
$this->params['breadcrumbs'][] = ['label' => 'Клиент', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
