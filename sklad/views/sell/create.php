<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Sell */

$this->title = 'Добавить Продам';
$this->params['breadcrumbs'][] = ['label' => 'Продам', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sell-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
