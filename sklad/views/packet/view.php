<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model sklad\models\Packet */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Поддоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packet-view">

        <p>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-2">
            <div id="showBarcode"></div>
        </div>
    </div>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'product_id',
                'amount',
                'note:ntext',
                'status',
                'left',
                'date',
                'space',
            ],
        ]);
        ?>

</div>
