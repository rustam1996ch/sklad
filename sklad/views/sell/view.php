<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model sklad\models\Sell */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Продам', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sell-view">

        <p>
            <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'date',
                'car_number',
                'note:ntext',
                'client_id',
                'status',
            ],
        ]) ?>

</div>
