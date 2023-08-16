<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use sklad\models\Client;


/* @var $this yii\web\View */
/* @var $searchModel sklad\models\search\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Оплати';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

app()->formatter->nullDisplay = '&mdash;';
?>


<div class="modal fade create-update-payment" tabindex="-1" role="dialog"
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

    [
        'attribute' => 'client_id',
        'format' => 'text',
        'hAlign' => 'center',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function($model){
            return $model->client->name;
        },
        'filter' => ArrayHelper::map(Client::find()->asArray()->all(), 'id', 'name'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'attribute' => 'date',
        'format' => 'date',
        'hAlign' => 'center',
        'value' => function ($model) {
            return $model->date;
        },
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
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
        'format' => 'decimal',
        'hAlign' => 'right',
        'width' => '200px',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'note',
        'format' => 'ntext',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],


    ['class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {view} {delete}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                return Html::button('<span class="fas fa-lg fa-pencil-alt" style="font-size:14px;"></span>',
                    [
                        'class' => 'update-payment btn btn-link',
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


<div class="payment-index">


    <?= GridView::widget([
        'id' => 'pjax-payment',
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
             <button class="btn btn-success create-payment" style="float: right; margin-right: 2px">Добавить</button>
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

    $('body').on('click', '.update-payment', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["payment/update"]) ?>',
            data: {id: id},
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-payment').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('.create-payment').click(function () {
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["payment/create"]) ?>',
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-payment').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });


    $('body').on('click', '#save-payment-form', function (e) {
        e.preventDefault();
        var form = $('#save-payment');
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            success: function (res) {
                if (res.success === 1) {
                    $('.create-update-payment').modal('hide');
                    $('#create-update-form').html(res.view);

                    $.pjax.reload({container: "#pjax-payment"});

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