<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model sklad\models\Rasxod */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Расходи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rasxod-view">

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
                'amount',
                'status',
                'cost',
                'product_id',
                'packet_id',
                'sell_id',
                'note:ntext',
            ],
        ]) ?>

</div>
