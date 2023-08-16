<?php

use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\Unit2Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unitи';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="modal fade create-update-unit2" tabindex="-1" role="dialog"
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

echo Html::button('Добавить unit2', [
    'class' => 'btn btn-success float-md-right create-unit2',
]);

//$this->endBlock();

?>

<div class="unit-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'condensed' => true,
        'hover' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [

                'attribute' => 'id',
                'format' => 'text',
                'filterInputOptions' => ['class' => 'form-control input-sm'],
            ],
            [

                'attribute' => 'name',
                'format' => 'text',
                'filterInputOptions' => ['class' => 'form-control input-sm'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="fas fa-trash"></span>', 'javascript:void(0)',
                            [
                                'data' => [
                                    'method' => 'POST',
                                    'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                    'pjax' => false
                                ],
                                'title' => 'Удалить',
                                'aria-label' => 'Удалить'
                            ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="fas fa-eye"></span>', 'javascript:void(0)', ['title' => 'Просмотр', 'aria-label' => 'Просмотр']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="fas fa-edit"></span>', 'javascript:void(0)',
                            [
                                'data' => [
                                    'id' => $model->id,
                                ],
                                'title' => 'Редактировать',
                                'aria-label' => 'Редактировать',
                                'class' => 'update-unit2'
                            ]);
                    }
                ],
                'contentOptions' => [
                    'nowrap' => 'nowrap',
                ],
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ]
    ]); ?>

</div>

<script type="text/javascript">
    <?php ob_start() ?>

    $('body').on('click', '.update-unit2', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["unit2/update"]) ?>',
            data: {id: id},
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-unit2').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('.create-unit2').click(function () {
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["unit2/create"]) ?>',
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-unit2').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });


    $('body').on('click', '#save-unit2-form', function (e) {
        e.preventDefault();
        var form = $('#save-unit2');
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            success: function (res) {
                if (res.success === 1) {
                    $('.create-update-unit2').modal('hide');
                    $('#create-update-form').html(res.view);

                    $.pjax.reload({container: "#pjax-unit2"});

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
