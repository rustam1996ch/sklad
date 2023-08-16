<?php

use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use sklad\models\Packet;
use sklad\models\Product;
use kartik\popover\PopoverX;

/* @var $this yii\web\View */
/* @var $searchModel sklad\models\search\ReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Приход';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
app()->formatter->nullDisplay = '&mdash;';
?>

<div class="modal fade create-update-receipt" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
//    [
//        'label' => '№',
//        'value' => function ($model) {
//            return $model->packet->id;
//        }
//    ],
    [
        'header' => 'Артикул',
        'value' => function ($model) {
            return ($model->product_id) ? $model->product->vendor_code : '';
        }
    ],
    [
        'header' => 'ПРОДУКТ',
        'value' => function ($model) {
            return ($model->product_id) ? $model->product->name : '';
        }
    ],
    [
        'label' => 'К-во',
        'attribute' => 'amount',
        'hAlign' => 'right',
        'format' => 'html',
        'value' => function ($model) {

            $amount_in_packet = $model->product->amount_in_packet;

            if ($model->amount >= $amount_in_packet && $amount_in_packet > 0) {
                $butunQismi = floor($model->amount / $amount_in_packet);
            } else {
                $butunQismi = 0;
            }
            $qoldiqQismi = $model->amount - ($butunQismi * $amount_in_packet);

            return "<span style='font-weight: bold; '>{$model->amount}</span>" . ' (' . $amount_in_packet . 'шт * ' . $butunQismi . 'упак + ' . ($qoldiqQismi != 0 ? $qoldiqQismi . 'шт' : '') . ')';
        }
    ],
    [
        'label' => 'Дата',
        'attribute' => 'date',
        'format' => 'datetime'
    ],
    [
        'header' => 'Бригадир',
        'value' => function ($model) {
            return ($model->packet_id) ? $model->packet->user->full_name : '';
        }
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'status',
        'format' => 'raw',
        'value' => function ($model) {
            return ($model->status == 0) ? "<span class='fas fa-times text-danger'></span>" : "<span class='fas fa-check text-success'></span>";
        },

        'filterType' => GridView::FILTER_SELECT2,
        'vAlign' => 'middle',
        'filter' => [null => '---', 1 => 'Проверено', 0 => 'Не Проверено'],
        'refreshGrid' => true,
        'editableOptions' => [
            'asPopover' => false,
            'size' => 'md',
            'formOptions' => ['action' => ['/receipt/status-update']],
            'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX_X,
            'pluginOptions' => ['threeState' => false],
            'editableValueOptions' => ['class' => 'text-success'],
            'inlineSettings' => [
                'templateBefore' => Editable::INLINE_BEFORE_1,
                // 'templateAfter' =>  Editable::INLINE_AFTER_2
                // 'label'=>false,
            ],
        ],
    ],


    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {view} {delete}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                return Html::a('<span class="fas fa-pencil-alt" style="font-size:14px;"></span>', ['creates', 'id' => $model->id],
                    [
                        'class' => 'update-sell btn btn-link',
                        // 'data-id' => $model->id,
                        'style' => 'display: contents',

                    ]);
            },
            'view' => function ($url, $model, $key) {
                return Html::a('<span class="fas fa-eye" style="font-size:14px;"></span>', ['view', 'id' => $model->id],
                    [
                        'data-id' => $model->id,
                        'class' => 'btn btn-link',
                        'title' => 'View',
                        'aria-label' => 'View',
                        'style' => 'display: contents',
                    ]);
            },
            'delete' => function ($url, $model, $key) {
                return Html::a('<span class="fa fa-trash" style="font-size:14px;"></span>', ['delete', 'id' => $model->id],
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
        // 'floatHeader' => true,
        'pjax' => false,
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
             <button class="btn btn-success create-receipt" style="float: right; margin-right: 2px">Добавить</button>
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
        'rowOptions' => function ($model, $key, $index) use ($id) {
            if ($model->id == $id) {
                return ['class' => 'table-warning'];
            } else {
                return [];
            }
        },
    ]); ?>
</div>

<script type="text/javascript">
    <?php ob_start() ?>

    $('body').on('click', '.update-receipt', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["receipt/update"]) ?>',
            data: {id: id},
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-receipt').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('.create-receipt').click(function () {
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["receipt/create"]) ?>',
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-receipt').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });


    $('body').on('click', '#save-receipt-form', function (e) {
        e.preventDefault();
        var form = $('#save-receipt');
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            success: function (res) {
                if (res.success === 1) {
                    $('.create-update-receipt').modal('hide');
                    $('#create-update-form').html(res.view);

                    $.pjax.reload({container: "#pjax-receipt"});

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
