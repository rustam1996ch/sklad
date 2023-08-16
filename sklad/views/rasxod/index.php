<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use sklad\models\Packet;
use sklad\models\Product;
use sklad\models\Sell;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel sklad\models\search\RasxodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отгрузка';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
app()->formatter->nullDisplay = '&mdash;';
?>

<div class="modal fade create-update-rasxod" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKomplektModalLabel">
                    <b>Добавить набор</b>
                </h5>
                <button type="button" class="close" aria-label="Close" data-dismiss="modal" data-original-title=""
                        title="">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="create-update-form">
                <?= $this->render('_form', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>


<?php //$this->beginBlock('view_actions');

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],

    [
        'attribute' => 'product_id',
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'width' => '300px',
        'hAlign' => GridView::ALIGN_CENTER,
        'value' => function($model){
            return $model->product->name;
        },
        'filter' => ArrayHelper::map(Product::find()->asArray()->all(), 'id', 'name'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'attribute' => 'packet_id',
        'format' => 'text',
        'width' => '300px',
        'hAlign' => GridView::ALIGN_CENTER,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return $model->product->name;
        },
        'filter' => ArrayHelper::map(Packet::find()->asArray()->all(), 'id', 'note'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'attribute' => 'sell_id',
        'format' => 'text',
        'width' => '300px',
        'hAlign' => GridView::ALIGN_CENTER,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return $model->sell->client->name;
        },
        'filter' => ArrayHelper::map(Sell::find()->all(), 'id', 'client.name'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'attribute' => 'date',
        'format' => 'date',
        'vAlign' => 'middle',
        'value' => function ($model) {
            return $model->date;
        },
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'options' => ['style' => 'width:200px; display:inline-block;',
                'class' => 'form-control'],
            'model' => $searchModel,
            'convertFormat' => true,
            'useWithAddon' => false,
            'pluginOptions' => [
                'locale' => ['format' => 'd.m.Y'],
                'separator' => ' - ',
                'opens' => 'right',
                'language' => 'ru',
                'pluginEvents' => [
                    'cancel.daterangepicker' => "function(ev, picker) {\$('#daterangeinput').val(''); // clear any inputs};"
                ],
            ]
        ]
    ],
    [
        'attribute' => 'amount',
        'format' => 'text',
        'hAlign' => 'right',
        'width' => '200px',
        'pageSummary' => true,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'cost',
        'format' => 'text',
        'hAlign' => 'right',
        'width' => '200px',
        'pageSummary' => true,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'note',
        'format' => 'ntext',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'status',
        'hAlign' => GridView::ALIGN_CENTER,
        'format' => 'text',
        'width' => '100px',
        'filter' => [1 => 'Актив', 0 => 'Неактив'],
        'value' => function($modal){
            return ($modal->status) ? 'Актив' : 'Неактив';
        },
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],


    ['class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {view} {delete}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                return Html::button('<span class="fas fa-lg fa-pencil-alt" style="font-size:14px;"></span>',
                    [
                        'class' => 'update-rasxod btn btn-link',
                        'data-id' => $model->id,
                        'style' => 'display: contents',

                    ]);
            },
            'view' => function ($url, $model, $key) {
                return Html::a('<span class="fas fa-lg fa-eye" style="font-size:14px;"></span>', ['view', 'id' => $model->id],
                    [
                        'data-id' => $model->id,
                        'class' => 'btn btn-link',
                        'title' => 'View',
                        'aria-label' => 'View',
                        'style' => 'display: contents',
                    ]);
            },
            'delete' => function ($url, $model, $key) {
                return Html::a('<span class="fa fa-lg fa-trash" style="font-size:14px;"></span>', ['delete', 'id' => $model->id],
                    ['class' => 'label btn-link',
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить этот элемент ?',
                            'method' => 'post',
                        ],
                        'title' => 'Delete',
                        'aria-label' => 'Delete',

                    ]);
            },
        ],
    ],
];

//$this->endBlock();

?>

<div class="rasxod-index">

    <?= GridView::widget([
        'id' => 'pjax-rasxod',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive' => true,
        'striped' => true,
        'condensed' => true,
        'bordered' => true,
        'hover' => true,
        // 'floatHeader' => true,
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
        'panelBeforeTemplate' => '
            {toolbarContainer}
             <button class="btn btn-success create-rasxod" style="float: right; margin-right: 2px">Добавить</button>
            {before}
        ',
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

<script type="text/javascript">
    <?php ob_start() ?>

    $('body').on('click', '.update-rasxod', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["rasxod/update"]) ?>',
            data: {id: id},
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-rasxod').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('.create-rasxod').click(function () {
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["rasxod/create"]) ?>',
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-rasxod').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });


    $('body').on('click', '#save-rasxod-form', function (e) {
        e.preventDefault();
        var form = $('#save-rasxod');
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            success: function (res) {
                if (res.success === 1) {
                    $('.create-update-rasxod').modal('hide');
                    $('#create-update-form').html(res.view);

                    $.pjax.reload({container: "#pjax-rasxod"});

                } else {
                    $('#create-update-form').html(res.view);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });



    <?php $this->registerJs(ob_get_clean()) ?>
</script>