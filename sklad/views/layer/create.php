<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Layer */

$this->title = 'Добавить Слой';
$this->params['breadcrumbs'][] = ['label' => 'Слой', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="layer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
