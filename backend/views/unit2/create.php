<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Unit */

$this->title = 'Добавить unit';
$this->params['breadcrumbs'][] = ['label' => 'Unitи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
