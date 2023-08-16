<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel sklad\models\search\SellSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список автомобилей';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
?>


<div class="modal fade create-update-sell" tabindex="-1" role="dialog"
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
        'attribute'=>'client_id',
        'value'=>function($model){
            return $model->client->name;
        },
        'filterType' => GridView::FILTER_SELECT2,
            'vAlign' => 'middle',
            'filter' => [null => '---'] + sklad\models\Client::dDListClient(),
            'headerOptions' => ['style' => 'width:200px'],
    ],
    [
        'attribute' => 'car_number',
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
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
        'attribute'=>'shipped_time',
        'format' => 'time',
    ],
    [   
        'attribute'=>'exit_time',
        'format' => 'time',
    ],
    [
        'label' => 'Проверено',
        'vAlign'=>'middle',
        'filter'=> ["1"=>"Проверено", "0"=>"Не проверено"],
        'format'=>'raw',
        'header' => '',
        'noWrap' => true,
            'value' => function ($model) {
                if($model->exit_time!==null){
                        return Html::a("<span class='glyphicon glyphicon-ok text-success'></span>",['check', 'id' => $model->id,'check'=>0],
                            [
                            'class' => 'btn btn-icon rounded-circle btn-success glow bx bx-check',
                            'title' => 'Редактировать',
                            'aria-label' => 'Редактировать',

                        ]);
                }else{
                   return Html::a("",['check', 'id' => $model->id,'check'=>1],
                            [
                            'class' => 'btn btn-icon rounded-circle btn-warning glow bx bx-x-circle',
                            'title' => 'Редактировать',
                            'aria-label' => 'Редактировать',

                        ]); 
                }               
            },
    ],
    ['class' => 'kartik\grid\ActionColumn',
        'template' => '{view}',
        'buttons'=>[
            'view' => function ($url, $model,$key)
            {
                return Html::button('<span class="fas fa-eye" style="font-size:14px;"></span>',
                [
                    'class'=>'view-product btn btn-link',
                    'data-id' => $model->id,
                    'title' => 'View',
                    'aria-label' => 'View',
                    'style' => 'display: contents',
                ]);
            },
        ],
    ],
];

//$this->endBlock();

?>

<div class="sell-index">

   
     <?= GridView::widget([
        'id' => 'pjax-sell',
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

<div class="modal fade text-left w-100" id="product-full-scrn" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel20" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel20">Подробно</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body" id="product-view-modal">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Закрыть</span>
                </button>
                <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Принимать</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
 <?php ob_start() ?>

    $('body').on('click', '.view-product', function () {
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["sell/views"]) ?>',
            data: {id: id},
            success: function (res) {
                console.log(res);
                $('#product-view-modal').html(res);
                $('#product-full-scrn').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });



<?php $this->registerJs(ob_get_clean()) ?> 
</script>