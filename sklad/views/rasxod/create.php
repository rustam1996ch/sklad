<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Rasxod */

$this->title = 'Добавить Расход';
$this->params['breadcrumbs'][] = ['label' => 'Расходи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rasxod-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
