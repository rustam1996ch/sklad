<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use sklad\models\Packet;
use sklad\models\Product;

/* @var $this yii\web\View */
/* @var $searchModel sklad\models\search\ReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Прибыль';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['foyda']];
?>

<?php //$this->beginBlock('view_actions');

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'header'=>'Продукт',
        'attribute' => 'name',
        'format' => 'text',
        'hAlign' => 'left',
        'value' => function ($model) {
            return $model['name'];
        },
    ],
    [
        'header' => 'Прибыль',
        'attribute' => 'foyda',
        'format' => 'decimal',
        'hAlign' => 'center',
        'width' => '120px',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'filter' => '',
        'pageSummary' => true,
    ],
];

//$this->endBlock();

?>

<div class="receipt-index">

    <?= GridView::widget([
        'id' => 'pjax-receipt',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive' => true,
        'striped' => true,
        'condensed' => true,
        'bordered' => true,
        'hover' => true,
        'floatHeader' => true,
        'pjax' => true,
//        'pjaxSettings'=>[
//            'neverTimeout'=>true,
//            'beforeGrid'=>'My fancy content before.',
//            'afterGrid'=>'My fancy content after.',
//        ],
//        'toggleDataContainer' => ['class' => 'btn-group-sm'],
//        'exportContainer' => ['class' => 'btn-group-sm'],
        'columns' => $gridColumns,
//        'headerRowOptions' => ['class' => 'kv-table-caption'],
//        'rowOptions' => ['class' => GridView::ALIGN_RIGHT],


        'panel' => [
            'type' => GridView::TYPE_ACTIVE,
            'before' => '{summary}',
            'after' => false,
            'summaryOptions' => [
                'class' => 'float-left',
                'style' => 'display: table; height: 38px;'
            ]
        ],
        'summaryOptions' => [
            'class' => 'summary',
            'style' => 'display: table-cell; vertical-align:middle;'
        ],
        'panelTemplate' => '
            {panelBefore}
            {items}
            {panelAfter}
            {panelFooter}
        ',
        'exportConfig' => [
            GridView::EXCEL => [
                'label' => '&nbsp;&nbsp;Excel',
            ],
        ],
        'export' => [
            'icon' => 'fas fa-external-link-alt',
            'fontAwesome' => true,
//            'menuOptions' => ['class' => 'grid-export-menu']
        ],
        'showPageSummary' => true,
        'pageSummaryRowOptions' => ['class' => 'kv-page-summary'],
    ]); ?>
</div>