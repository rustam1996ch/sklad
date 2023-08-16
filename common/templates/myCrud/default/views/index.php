<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
<?= $generator->enablePjax ? "use yii\widgets\Pjax;\n" : '' ?>
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;


/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass)) . 'и') ?>;
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="modal fade create-update-<?= $generator->controllerID ?>" tabindex="-1" role="dialog"
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
                <?php echo "<?= " ?>$this->render('_form', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>


<?php echo "<?php "; ?>$this->beginBlock('view_actions');

echo    Html::button('Добавить <?= $generator->controllerID ?>', [
'class' => 'btn btn-success float-md-right create-<?= $generator->controllerID ?>',
]);

$this->endBlock();

?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <?php if (!empty($generator->searchModelClass)): ?>
        <?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php endif; ?>

    <p>
        <?= "<?php " ?>
        Html::a(<?= $generator->generateString('Добавить ' . lcfirst(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>
        , ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $generator->enablePjax ? "<?php Pjax::begin(['id' => 'pjax-" . $generator->controllerID . "']); ?>\n" : "\n" ?>
    <?php if ($generator->indexWidgetType === 'grid'): ?>
        <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n" : '' ?>
        'condensed' => true,
        'hover' => true,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        <?php
        $count = 0;
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {

                $relation_boolean = false;
                if(strpos($name,"_")){
                    $columnExplode = explode('_',$name);
                    $ModelName = ucfirst($columnExplode[0]);
                    $relation_boolean = true;
                }

                if (++$count < 6) {
                    if($relation_boolean){
                        echo "                [\n
                    'attribute'=>'" . $name .  "',\n'format'=>'raw',\n'filter'=>\yii\helpers\ArrayHelper::map($ModelName::find()->all(), 'id', 'name'),\n'filterType'=>GridView::FILTER_SELECT2,\n'filterWidgetOptions' => 
                        [\n
                                'size' => \kartik\select2\Select2::BS_BADGE,\n
                                'options' => ['prompt' => 'Выберите'],\n
                                'pluginOptions' => ['allowClear' => false],\n
                            ],\n],\n";
                    }else{
                        echo "                '" . $name . "',\n";
                    }
                } else {
                    if($relation_boolean){
                        echo "                [\n
                    'attribute'=>'" . $name .  "',\n'format'=>'raw',\n'filter'=>\yii\helpers\ArrayHelper::map($ModelName::find()->all(), 'id', 'name'),\n'filterType'=>GridView::FILTER_SELECT2,\n'filterWidgetOptions' => 
                        [\n
                                'size' => \kartik\select2\Select2::BS_BADGE,\n
                                'options' => ['prompt' => 'Выберите'],\n
                                'pluginOptions' => ['allowClear' => false],\n
                            ],\n],\n";
                    }else{
                        echo "                // '" . $name . "',\n";
                    }
                }
            }
        } else {
            foreach ($tableSchema->columns as $column) {
                $format = $generator->generateColumnFormat($column);

                $relation_boolean = false;
                if(strpos($column->name,"_")){
                    $columnExplode = explode('_',$column->name);
                    $ModelName = ucfirst($columnExplode[0]);
                    $relation_boolean = true;
                }
                if($relation_boolean){
                    echo "                [
                    'attribute'=>'" . $column->name .  "',
                    'format'=>'raw',
                    'filter'=>\yii\helpers\ArrayHelper::map($ModelName::find()->all(), 'id', 'name'),
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => 
                        [
                            'size' => \kartik\select2\Select2::BS_BADGE,
                            'options' => ['prompt' => 'Выберите'],
                            'pluginOptions' => ['allowClear' => false],
                        ],
                     ],";
                }else if($column->name == 'status'){
                    echo "                [
                    'attribute'=>'" . $column->name .  "',
                    'value' => function (\$model) {
                        return (\$model->$column->name == 1) ? 'Активный' : 'Не активный';
                    },
                    'filter' => ['1' => 'Активный','0' => 'Не активный']
                    ],";
                }
                else if ($column->name == 'date' || $column->name == 'created') {
                    echo "                [
                    'attribute' => '" . $column->name .  "',
                    'format' => 'date',
                    'vAlign' => 'middle',
                    'value' => function (\$model) {
                        return \$model->$column->name;
                    },
                    'filterType' => GridView::FILTER_DATE_RANGE,
                    'filterWidgetOptions' => [
                        'model' => \$searchModel,
                        'convertFormat' => true,
                        'useWithAddon' => false,
                        'pluginOptions' => [
                            'locale' => ['format' => 'd.m.Y'],
                            'separator' => ' - ',
                            'opens' => 'right',
                            'language' => 'ru',
                            'pluginEvents' => [
                                'cancel.daterangepicker' => \"function(ev, picker) {\\$('#daterangeinput').val(''); // clear any inputs};\"
                            ],
                        ]
                    ]
                  ],";
                }else{
                    echo "                [\n
            'attribute'=>'" . $column->name .  "',\n'format'=>'" .($format === 'text' ? "text" : $format) . "',\n'filterInputOptions'=>['class'=>'form-control input-transparent'],\n],\n";
                }

            }
        }
        ?>

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{view}{delete}',
            'buttons' => [
                'delete' => function ($url, $model) {
                    return Html::a(
                    '<span class="la la-trash"></span>','javascript:void(0)',
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
                    '<span class="la la-eye"></span>','javascript:void(0)', ['title' => 'Просмотр', 'aria-label' => 'Просмотр']);
                },
                'update' => function ($url, $model) {
                    return Html::a(
                    '<span class="la la-pencil"></span>','javascript:void(0)',
                        [
                            'data' => [
                            'id' => $model->id,
                        ],
                        'title' => 'Редактировать',
                        'aria-label' => 'Редактировать',
                        'class' => 'update-<?= $generator->controllerID ?>'
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
    <?php else: ?>
        <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
        return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
        ]) ?>
    <?php endif; ?>
    <?= $generator->enablePjax ? "<?php Pjax::end(); ?>\n" : '' ?>

</div>

<?= '<script type="text/javascript">' ?>
<?php echo "\n <?php ob_start() ?>"; ?>


    $('body').on('click', '.update-<?= $generator->controllerID ?>', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: '<?= '<?= yii\helpers\Url::to(["' . Inflector::camel2id(StringHelper::basename($generator->controllerID)) . '/update"]) ?>' ?>',
            data: {id: id},
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-<?= $generator->controllerID ?>').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('.create-<?= $generator->controllerID ?>').click(function () {
        $.ajax({
            type: 'get',
            url: '<?= '<?= yii\helpers\Url::to(["' . Inflector::camel2id(StringHelper::basename($generator->controllerID)) . '/create"]) ?>' ?>',
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-<?= $generator->controllerID ?>').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });



    $('body').on('click', '#save-<?= $generator->controllerID ?>-form', function (e) {
        e.preventDefault();
        var form = $('#save-<?= $generator->controllerID ?>');
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            success: function (res) {
                if (res.success === 1) {
                    $('.create-update-<?= $generator->controllerID ?>').modal('hide');
                    $('#create-update-form').html(res.view);

                    $.pjax.reload({container: "#pjax-<?= $generator->controllerID ?>"});

                } else {
                    $('#create-update-form').html(res.view);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });



<?php echo "<?php \$this->registerJs(ob_get_clean()) ?> \n"; ?>
<?= '</script>' ?>
