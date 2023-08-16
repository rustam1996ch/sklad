<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use kartik\popover\PopoverX;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSidebarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Sidebarи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-sidebar-index">

    <?= DynaGrid::widget([
        'options'=>['id'=>'dynagrid-menu-sidebar'],
        'theme'=>'panel-info',
        'showPersonalize'=>true,
        'storage'=>DynaGrid::TYPE_COOKIE,
        'gridOptions'=>[
            'id'=>"grid-menu-sidebar",
            'dataProvider'=>$dataProvider,

            'tableOptions' => ['style'=>'margin-bottom:0px;'],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],

            'showPageSummary'=>false,
            'floatHeader'=>false,
            'pjax'=>false,
            'panel'=>[
                'type'=>'success card',
//                'heading'=>'<h3 class="panel-title">'.$this->title.'</h3>',
                'before' =>  '<div style="padding-top: 7px;"></div>',
                'after' => false
            ],
            'resizableColumns'=>false,
            'persistResize'=>false,
            'toolbar' =>  [
                ['content'=>Html::a('<i class="fa fa-plus"></i> Добавить',['create'], ['class' => 'btn btn-info']),],
                '{export}',
            ],
            'exportConfig' => [
                GridView::EXCEL => [
                    'label' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Excel',
                    'icon' => 'floppy-remove',
                    'showHeader' => true,
                    'showPageSummary' => true,
                    'showFooter' => true,
                    'showCaption' => true,
                    'worksheet' => 'ExportWorksheet',
                    'filename' => 'Menyular',
                    'alertMsg' => 'The EXCEL export file will be generated for download.',
                    'cssFile' => '',
                    'options' => ['title' => 'Save as Excel']
                ],
            ],
        ],
        'options'=>['id'=>'dynagrid-0'],
        'columns' => [
//            ['class' => 'kartik\grid\SerialColumn'],

            [
                'class'=>'kartik\grid\ExpandRowColumn',
                'width'=>'50px',
                'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detailUrl'=>\yii\helpers\Url::to(['/menu-sidebar/detail']),
//                'extraData'=> ['id'=>1],
                'detailOptions'=>['style'=>'margin-left:15px;'],
                'headerOptions'=>['class'=>'kartik-sheet-style'] ,
                'expandOneOnly'=>true
            ],
            [
                'attribute' => 'id',
                'hAlign' => 'middle',
                'vAlign' => 'middle',
            ],

            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'name',
                'editableOptions' => [
                    'asPopover' => false,
                    'preHeader'=>'<i class="nav-icon fas fa-pen"></i> ',
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'placement' => PopoverX::ALIGN_RIGHT,

                ],
                'hAlign' => 'middle',
                'vAlign' => 'middle',
                'refreshGrid' => true,
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'link',
                'editableOptions' => [
                    'asPopover' => false,
                    'preHeader'=>'<i class="nav-icon fas fa-penfa-pen"></i> ',
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'placement' => PopoverX::ALIGN_LEFT,
                    'valueIfNull'=>'&nbsp;&nbsp;&nbsp;',
                ],
                'hAlign' => 'middle',
                'vAlign' => 'middle',
                'refreshGrid' => true,
            ],

            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'c_order',
                'editableOptions' => [
                    'asPopover' => false,
                    'preHeader'=>'<i class="nav-icon fas fa-pen"></i> ',
                    'inputType' => \kartik\editable\Editable::INPUT_SPIN,
                    'options' => [
                        'pluginOptions' => ['min' => 0, 'max' => 5000]
                    ],
                    'placement' => PopoverX::ALIGN_LEFT,
                ],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'refreshGrid' => true,
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'status',
                'editableOptions' => [
                    'asPopover' => false,
                    'preHeader'=>'<i class="nav-icon fas fa-penfa-pen"></i> ',
                    'inputType' => \kartik\editable\Editable::INPUT_SWITCH,
                    'displayValueConfig' => [
                        0 => '<span class="text-danger">x</span>',
                        1 => '<span class="fa fa-check text-success"></span>',
                    ],
                    'options' => [
                        'pluginOptions' => [
                            //                            'handleWidth' => 60,
                            'onColor' => 'success',
                            'offColor' => 'danger',
                            'onText' => '<span class="fa fa-check"></span>',
                            'offText' => '<span>x</span>'
                        ]
                    ],
                    'placement' => PopoverX::ALIGN_LEFT,
                ],
                'hAlign' => 'middle',
                'vAlign' => 'middle',
                'refreshGrid' => true,
            ],

            ['class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons'=>[
                    'update' => function ($url, $model,$key){return Html::a('<i class="fa fa-pen"></i>',['update','id' => $model->id],
                        [
                            'data-id' => $model->id,
                            'class' => 'btn btn-link',
                            'title' => 'Изменить',
                            'aria-label' => 'Изменить',

                        ]);
                    },
                    'delete' => function ($url, $model, $key){return Html::a('<i class="fa fa-trash" style="color: #ff6174;"></i>', ['delete', 'id' => $model->id],
                        ['class' => 'label btn-link',
                            'data' => [
                                'confirm' =>'Вы уверены, что хотите удалить этот элемент ?',
                                'method' => 'post',
                            ],
                            'title' => 'Удалить',
                            'aria-label' => 'Удалить',

                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
