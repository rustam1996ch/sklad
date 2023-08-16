<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Packet */

$this->title = 'Добавить Поддон';
$this->params['breadcrumbs'][] = ['label' => 'Поддоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packet-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
