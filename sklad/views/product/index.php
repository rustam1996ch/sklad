<?php
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use sklad\models\Client;
use sklad\models\Connertor;
use sklad\models\Gofra;
use sklad\models\Layer;
use sklad\models\ProductType;
use sklad\models\Territory;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel sklad\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукти';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

app()->formatter->nullDisplay = '&mdash;';
?>
<style type="text/css">
    td.skip-export{
        position:sticky;
        right:0px;
        background-color: #fff;
        /*z-index: 1000;*/
    }
    th.skip-export{
        position:sticky;
        right:0px;
        background-color: #fff;
        /*z-index: 1000;*/
    }
</style>
<script>
    window.baseProduct = false;
</script>
<div class="modal fade create-update-product" tabindex="-1" role="dialog"
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
        'attribute' => 'client_id',
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return $model->productType->client_id ? $model->client->name : '';
        },
        'filter' => ArrayHelper::map(Client::find()->asArray()->all(), 'id', 'name'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'attribute' => 'territory_id',
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return (isset($model->territory_id)) ? $model->territory->name : '';
        },
        'filter' => ArrayHelper::map(Territory::find()->asArray()->all(), 'id', 'name'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'attribute' => 'product_type_id',
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return $model->productType->name;
        },
        'filter' => ArrayHelper::map(ProductType::find()->filterWhere(['client_id' => $searchModel->client_id])->asArray()->all(), 'id', 'name'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'attribute' => 'vendor_code',
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'name',
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],

    ],
    [
        'attribute' => 'mark',
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],

//    [
//        'attribute' => 'unit_id',
//        'format' => 'text',
//        'filterInputOptions' => ['class' => 'form-control input-sm'],
//        'value' => function($model){
//            return $model->unit->name;
//        },
//        'filter' => ArrayHelper::map(Unit::find()->asArray()->all(), 'id', 'name'),
//        'filterType' => GridView::FILTER_SELECT2,
//        'filterWidgetOptions' => [
//            'options' => ['prompt' => ''],
//            'pluginOptions' => ['allowClear' => true],
//        ],
//    ],
    [
        'attribute' => 'x',
        'format' => 'text',
        'hAlign' => GridView::ALIGN_CENTER,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'y',
        'format' => 'text',
        'hAlign' => GridView::ALIGN_CENTER,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'z',
        'format' => 'text',
        'hAlign' => GridView::ALIGN_CENTER,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'a',
        'format' => 'text',
        'hAlign' => GridView::ALIGN_CENTER,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'b',
        'format' => 'text',
        'hAlign' => GridView::ALIGN_CENTER,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'mkv',
        'value' => function ($model) {
            if (!$model['mkv']) {
                return $model['a'] * $model['b'] / 1000000;
            }
        },
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'fraction',
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'cost',
        'format' => ['decimal', 0],
        'noWrap' => true,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'price',
        'format' => ['decimal', 0],
        'noWrap' => true,
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'layer1_id',
        'contentOptions' => ['nowrap' => ''],
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return (isset($model->layer1_id)) ? $model->layer1->name : '';
        },
        'filter' => ArrayHelper::map(Layer::find()->asArray()->all(), 'id', 'name'),
    ],
    [
        'attribute' => 'layer2_id',
        'contentOptions' => ['nowrap' => ''],
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return (isset($model->layer2_id)) ? $model->layer2->name : '';
        },
        'filter' => ArrayHelper::map(Layer::find()->asArray()->all(), 'id', 'name'),
    ],
    [
        'attribute' => 'layer3_id',
        'contentOptions' => ['nowrap' => ''],
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return (isset($model->layer3_id)) ? $model->layer3->name : '';
        },
        'filter' => ArrayHelper::map(Layer::find()->asArray()->all(), 'id', 'name'),
    ],
    [
        'attribute' => 'layer4_id',
        'contentOptions' => ['nowrap' => ''],
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return (isset($model->layer4_id)) ? $model->layer4->name : '';
        },
        'filter' => ArrayHelper::map(Layer::find()->asArray()->all(), 'id', 'name'),
    ],
    [
        'attribute' => 'layer5_id',
        'contentOptions' => ['nowrap' => ''],
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return (isset($model->layer5_id)) ? $model->layer5->name : '';
        },
        'filter' => ArrayHelper::map(Layer::find()->asArray()->all(), 'id', 'name'),
    ],
    [
        'attribute' => 'gofra1_id',
        'contentOptions' => ['nowrap' => ''],
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return (isset($model->gofra1_id)) ? $model->gofra1->name : '';
        },
        'filter' => ArrayHelper::map(Gofra::find()->asArray()->all(), 'id', 'name'),
    ],
    [
        'attribute' => 'gofra2_id',
        'contentOptions' => ['nowrap' => ''],
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return (isset($model->gofra2_id)) ? $model->gofra2->name : '';
        },
        'filter' => ArrayHelper::map(Gofra::find()->asArray()->all(), 'id', 'name'),
    ],
    [
        'attribute' => 'connertor_id',
        'contentOptions' => ['nowrap' => ''],
        'format' => 'text',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'value' => function ($model) {
            return (isset($model->connertor_id)) ? $model->connertor->name : '';
        },
        'filter' => ArrayHelper::map(Connertor::find()->asArray()->all(), 'id', 'name'),
    ],
    [
        'attribute' => 'weight_gofra',
        'format' => 'decimal',
    ],
    'point_connector',
    'amount_in_packet',
    [
        'attribute' => 'status',
        'class' => 'kartik\grid\BooleanColumn',
        'hAlign' => GridView::ALIGN_CENTER,
        'width' => '100px',
        'trueLabel' => 'Актив',
        'falseLabel' => 'Неактив',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view} {update} {delete}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                if(isRoleAllowed([2,3,5])){
                    return Html::button('<span class="fas fa-pencil-alt" style="font-size:14px;"></span>',
                        [
                            'class' => 'update-product btn btn-link',
                            'data-id' => $model->id,
                            'style' => 'display: contents',

                        ]);
                }
            },
            'view' => function ($url, $model, $key) {
                if(isRoleAllowed([3,2,4,5])){
                    return Html::button('<span class="fas fa-eye" style="font-size:14px;"></span>',
                        [
                            'class' => 'view-product btn btn-link',
                            'data-id' => $model->id,
                            'title' => 'View',
                            'aria-label' => 'View',
                            'style' => 'display: contents',

                        ]);
                }
            },
            'delete' => function ($url, $model, $key) {
                if(isRoleAllowed([2,5])){
                    return Html::a('<span class="fa fa-trash" style="font-size:14px;"></span>', ['delete', 'id' => $model->id],
                        ['class' => 'label btn-link',
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить этот элемент ?',
                                'method' => 'post',
                            ],
                            'title' => 'Delete',
                            'aria-label' => 'Delete',

                        ]);
                }
            },
        ],
    ],
];

//$this->endBlock();

?>
<?php
    if(isRoleAllowed([2,3,5])) {
        $panelBeforeTemplate = '{toolbarContainer}'
            . '<a href="' . \yii\helpers\Url::to(['/product-excel/product-excel/excel']) . '" class="btn btn-outline-secondary" style="float: right; margin-right: 2px">Импорт</a>'
            . '<button class="btn btn-success create-product" style="float: right; margin-right: 2px">Добавить</button>'
            . '{before}';
    }else{
        $panelBeforeTemplate = '{toolbarContainer}'
            . '{before}';
    }
?>
<div class="product-index">
    <?= GridView::widget([
        'id' => 'pjax-product',
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
        'panelBeforeTemplate' => $panelBeforeTemplate,
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

<!--for view-->
<div class="modal fade text-left w-100" id="product-full-scrn" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel20" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel20">Продукт</h4>
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

    $('body').on('click', '.update-product', function () {
        var id = $(this).data('id');
        window.baseProduct = false;
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["product/update"]) ?>',
            data: {id: id},
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-product').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('body').on('click', '.view-product', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["product/view"]) ?>',
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

    $('.create-product').click(function () {
        window.baseProduct = true;
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["product/create"]) ?>',
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-product').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });


    $('body').on('click', '#save-product-form', function (e) {
        e.preventDefault();
        var form = $('#save-product');
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            success: function (res) {
                if (res.success === 1) {
                    $('.create-update-product').modal('hide');
                    $('#create-update-form').html(res.view);

                    $.pjax.reload({container: "#pjax-product"});

                } else {
                    $('#create-update-form').html(res.view);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });


    $('body').on('change', '#product-product_type_id', function (e) {//product_type_id oxirgisini oladi
        let product_type_id = e.target.value;
        // console.log(product_type_id);
        if(product_type_id != ''){
            if(window.baseProduct){
                $.ajax({
                    type: 'get',
                    url: '<?= yii\helpers\Url::to(["product-type-id"]) ?>',
                    data: {product_type_id: product_type_id},
                    success: function (res) {
                        console.log(res.product);

                        //product-territory_id begin
                        let territory_id = document.getElementById('product-territory_id');
                        territory_id.value = res.product.territory_id;
                        let territory_id_container = document.getElementById('select2-product-territory_id-container');
                        let spanTerritory_id_container = territory_id_container.getElementsByTagName('span')[0];
                        spanTerritory_id_container.setAttribute('data-select2-id',res.product.territory_id);
                        spanTerritory_id_container.innerHTML = res.territory;
                        //product-territory_id end

                        document.getElementById('product-vendor_code').value = res.product.vendor_code;
                        document.getElementById('product-name').value = res.product.name;
                        document.getElementById('product-x').value = res.product.x;
                        document.getElementById('product-y').value = res.product.y;
                        document.getElementById('product-z').value = res.product.z;
                        document.getElementById('product-cost').value = res.product.cost;
                        document.getElementById('product-price').value = res.product.price;
                        document.getElementById('product-a').value = res.product.a;
                        document.getElementById('product-b').value = res.product.b;
                        document.getElementById('product-mkv').value = res.product.mkv;
                        // document.getElementById('product-fraction').value = res.product.fraction;
                        document.getElementById('product-weight_gofra').value = res.product.weight_gofra;
                        document.getElementById('product-mark').value = res.product.mark;
                        document.getElementById('product-point_connector').value = res.product.point_connector;
                        document.getElementById('product-amount_in_packet').value = res.product.amount_in_packet;

                        //1 СЛОЙ begin
                        document.getElementById('product-layer1_id').value = res.product.layer1_id;
                        let layer1_id_container = document.getElementById('select2-product-layer1_id-container');
                        let spanLayer1_id_container = layer1_id_container.getElementsByTagName('span')[0];
                        spanLayer1_id_container.setAttribute('data-select2-id',res.product.layer1_id);
                        spanLayer1_id_container.innerHTML = res.layer1;
                        //1 СЛОЙ end

                        //2 СЛОЙ begin
                        document.getElementById('product-layer2_id').value = res.product.layer2_id;
                        let layer2_id_container = document.getElementById('select2-product-layer2_id-container');
                        let spanLayer2_id_container = layer2_id_container.getElementsByTagName('span')[0];
                        spanLayer2_id_container.setAttribute('data-select2-id',res.product.layer2_id);
                        spanLayer2_id_container.innerHTML = res.layer2;
                        //2 СЛОЙ end

                        //3 СЛОЙ begin
                        document.getElementById('product-layer3_id').value = res.product.layer3_id;
                        let layer3_id_container = document.getElementById('select2-product-layer3_id-container');
                        let spanLayer3_id_container = layer3_id_container.getElementsByTagName('span')[0];
                        spanLayer3_id_container.setAttribute('data-select2-id',res.product.layer3_id);
                        spanLayer3_id_container.innerHTML = res.layer3;
                        //3 СЛОЙ end

                        //4 СЛОЙ begin
                        document.getElementById('product-layer4_id').value = res.product.layer4_id;
                        let layer4_id_container = document.getElementById('select2-product-layer4_id-container');
                        let spanLayer4_id_container = layer4_id_container.getElementsByTagName('span')[0];
                        spanLayer4_id_container.setAttribute('data-select2-id',res.product.layer4_id);
                        spanLayer4_id_container.innerHTML = res.layer4;
                        //4 СЛОЙ end

                        //5 СЛОЙ begin
                        document.getElementById('product-layer5_id').value = res.product.layer5_id;
                        let layer5_id_container = document.getElementById('select2-product-layer5_id-container');
                        let spanLayer5_id_container = layer5_id_container.getElementsByTagName('span')[0];
                        spanLayer5_id_container.setAttribute('data-select2-id',res.product.layer5_id);
                        spanLayer5_id_container.innerHTML = res.layer5;
                        //5 СЛОЙ end

                        //ТИП ГОФРЫ 1 begin
                        document.getElementById('product-gofra1_id').value = res.product.gofra1_id;
                        let gofra1_id_container = document.getElementById('select2-product-gofra1_id-container');
                        let spanGofra1_id_container = gofra1_id_container.getElementsByTagName('span')[0];
                        spanGofra1_id_container.setAttribute('data-select2-id',res.product.gofra1_id);
                        spanGofra1_id_container.innerHTML = res.gofra1;
                        //ТИП ГОФРЫ 1 end

                        //ТИП ГОФРЫ 2 begin
                        document.getElementById('product-gofra2_id').value = res.product.gofra2_id;
                        let gofra2_id_container = document.getElementById('select2-product-gofra2_id-container');
                        let spanGofra2_id_container = gofra2_id_container.getElementsByTagName('span')[0];
                        spanGofra2_id_container.setAttribute('data-select2-id',res.product.gofra2_id);
                        spanGofra2_id_container.innerHTML = res.gofra2;
                        //ТИП ГОФРЫ 2 end

                        //СОЕД begin
                        document.getElementById('product-connertor_id').value = res.product.connertor_id;
                        let connertor_id_container = document.getElementById('select2-product-connertor_id-container');
                        let spanConnertor_id_container = connertor_id_container.getElementsByTagName('span')[0];
                        spanConnertor_id_container.setAttribute('data-select2-id',res.product.connertor_id);
                        spanConnertor_id_container.innerHTML = res.connertor;
                        //СОЕД end

                        //product-vendor_code
                        // let productAmountInPacket = document.getElementById('productAmountInPacket');
                        // productAmountInPacket.value = res.amount_in_packet;
                        // productAmountInPacket.setAttribute("data-product_id", product_id);
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }
        }
    });


    <?php $this->registerJs(ob_get_clean()) ?>
</script>
