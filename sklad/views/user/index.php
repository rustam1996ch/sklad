<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel sklad\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
app()->formatter->nullDisplay = '&mdash;';
?>


<div class="modal fade create-update-user" tabindex="-1" role="dialog"
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
        'attribute'=>'full_name',
        'format'=>'text',
        'filterInputOptions'=>['class'=>'form-control input-transparent'],
    ],
    [
        'attribute'=>'username',
        'format'=>'text',
        'filterInputOptions'=>['class'=>'form-control input-transparent'],
    ],
    [
        'attribute'=>'role_id',
        'format'=>'raw',
        'value' => function($model){
            return (isset($model->role_id)) ? $model->role->name : '';
        },
        'filter'=>\yii\helpers\ArrayHelper::map(\sklad\models\Role::find()->all(), 'id', 'name'),
        'filterType'=>GridView::FILTER_SELECT2,
        'filterWidgetOptions' =>
            [
                'size' => \kartik\select2\Select2::BS_BADGE,
                'options' => ['prompt' => 'Выберите'],
                'pluginOptions' => ['allowClear' => false],
            ],
    ],
    [
        'attribute'=>'email',
        'format'=>'email',
        'filterInputOptions'=>['class'=>'form-control input-transparent'],
    ],
    [
        'attribute'=>'status',
        'value' => function ($model) {
            return ($model->status == 10) ? 'Активный' : 'Не активный';
        },
        'filter' => ['10' => 'Активный','0' => 'Не активный']
    ],

    ['class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {delete}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                if($model->id == app()->user->identity->id){
                return Html::button('<span  class="fas fa-pencil-alt "></span>',
                    [
                        'class' => 'update-user btn btn-link',
                        'data-id' => $model->id,
                        'style' => 'display: contents',

                    ]);
                }
            },
            'delete' => function ($url, $model, $key) {
                if(isRoleAllowed([1,2,5])) {
                    return Html::a('<span   class="fa fa-trash "></span>', ['delete', 'id' => $model->id],
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

<div class="user-index">

    <?= GridView::widget([
        'id' => 'pjax-user',
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
             <button class="btn btn-success create-user" style="float: right; margin-right: 2px">Добавить</button>
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

    $('body').on('click', '.update-user', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["user/update"]) ?>',
            data: {id: id},
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-user').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('.create-user').click(function () {
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["user/create"]) ?>',
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-user').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });



    $('body').on('click', '#save-user-form', function (e) {
        e.preventDefault();
        var form = $('#save-user');
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            success: function (res) {
                if (res.success === 1) {
                    $('.create-update-user').modal('hide');
                    $('#create-update-form').html(res.view);

                    $.pjax.reload({container: "#pjax-user"});

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