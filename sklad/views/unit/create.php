<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Unit */

$this->title = 'Добавить Единица Измерения';
$this->params['breadcrumbs'][] = ['label' => 'Единица Измерения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
