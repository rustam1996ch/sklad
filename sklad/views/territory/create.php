<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Territory */

$this->title = 'Добавить territory';
$this->params['breadcrumbs'][] = ['label' => 'Territoryи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="territory-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
