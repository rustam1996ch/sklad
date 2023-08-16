<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Gofra */

$this->title = 'Добавить Тип гофры';
$this->params['breadcrumbs'][] = ['label' => 'Тип гофры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gofra-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
