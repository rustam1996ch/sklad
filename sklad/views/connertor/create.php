<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sklad\models\Connertor */

$this->title = 'Добавить Соед';
$this->params['breadcrumbs'][] = ['label' => 'Соед', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="connertor-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
