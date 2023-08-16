<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use kartik\popover\PopoverX;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menyular';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-detail">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'id'=>"grid-p{$parent_id}",
        'dataProvider'=>$dataProvider,
//            'filterModel'=>$searchModel,

        'tableOptions' => ['style'=>'margin-bottom:0px;'],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],

        'showPageSummary'=>false,
        'floatHeader'=>false,
        'pjax'=>false,
        'panel'=>[
            'type'=>GridView::TYPE_PRIMARY,
//                'heading'=>'<h3 class="panel-title">'.$this->title.'</h3>',
            'before' =>  '<div style="padding-top: 7px;"></div>',
            'after' => false
        ],
        'resizableColumns'=>false,
        'persistResize'=>false,
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="fa fa-plus"></i> Добавить',['create', 'parent_id'=>$parent_id], ['class' => 'btn btn-info']),
            ],
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
                    'preHeader'=>'<i class="glyphicon glyphicon-edit"></i> ',
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'asPopover' => false,
                    'format' => \kartik\editable\Editable::FORMAT_LINK,
                    'inlineSettings' => [
                        'options' => ['class'=>''],
//                        'closeButton' => '<button type="button" class="kv-editable-close close" title="Yopish"><i class="glyphicon glyphicon-remove"></i></button>',
                        'closeButton' => '<button type="button" class="btn btn-sm btn-warning kv-editable-close" style="margin:2px 4px 0 0;" title="Yopish"><i class="glyphicon glyphicon-remove"></i></button>',
                        'templateBefore' => <<< HTML
<div class="kv-editable-form-inline">
    {loading}
HTML
                        ,'templateAfter' => <<< HTML
    <div class="form-group">
        {buttons}{close}
    </div>
</div>
HTML
                    ]
                ],
                'hAlign' => 'middle',
                'vAlign' => 'middle',
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'link',
                'editableOptions' => [
                    'preHeader'=>'<i class="glyphicon glyphicon-edit"></i> ',
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'asPopover' => false,
                    'valueIfNull'=>'&nbsp;&nbsp;&nbsp;',
                    'format' => \kartik\editable\Editable::FORMAT_LINK,
                    'inlineSettings' => [
                        'options' => ['class'=>''],
//                        'closeButton' => '<button type="button" class="kv-editable-close close" title="Yopish"><i class="glyphicon glyphicon-remove"></i></button>',
                        'closeButton' => '<button type="button" class="btn btn-sm btn-warning kv-editable-close" style="margin:2px 4px 0 0;" title="Yopish"><i class="glyphicon glyphicon-remove"></i></button>',
                        'templateBefore' => <<< HTML
<div class="kv-editable-form-inline">
    {loading}
HTML
                        ,'templateAfter' => <<< HTML
    <div class="form-group">
        {buttons}{close}
    </div>
</div>
HTML
                    ]
                ],
                'hAlign' => 'middle',
                'vAlign' => 'middle',
            ],

            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'c_order',
                'editableOptions' => [
                    'preHeader'=>'<i class="glyphicon glyphicon-edit"></i> ',
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'asPopover' => false,
                    'format' => \kartik\editable\Editable::FORMAT_LINK,
                    'inlineSettings' => [
                        'options' => ['class'=>''],
//                        'closeButton' => '<button type="button" class="kv-editable-close close" title="Yopish"><i class="glyphicon glyphicon-remove"></i></button>',
                        'closeButton' => '<button type="button" class="btn btn-sm btn-warning kv-editable-close" style="margin:2px 4px 0 0;" title="Yopish"><i class="glyphicon glyphicon-remove"></i></button>',
                        'templateBefore' => <<< HTML
<div class="kv-editable-form-inline">
    {loading}
HTML
                        ,'templateAfter' => <<< HTML
    <div class="form-group">
        {buttons}{close}
    </div>
</div>
HTML
                    ]
                ],
                'hAlign' => 'middle',
                'vAlign' => 'middle',
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'status',
                'editableOptions' => [
                    'preHeader'=>'<i class="glyphicon glyphicon-edit"></i> ',
                    'inputType' => \kartik\editable\Editable::INPUT_SWITCH,
                    'displayValueConfig' => [
                        0 => '<span class="glyphicon glyphicon-remove text-danger"></span>',
                        1 => '<span class="glyphicon glyphicon-ok text-success"></span>',
                    ],
                    'options' => [
                        'pluginOptions' => [
                            //                            'handleWidth' => 60,
                            'onColor' => 'success',
                            'offColor' => 'danger',
                            'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                            'offText' => '<i class="glyphicon glyphicon-remove"></i>'
                        ]
                    ],
                    'asPopover' => false,
                    'inlineSettings' => [
                        'options' => ['class'=>''],
//                        'closeButton' => '<button type="button" class="kv-editable-close close" title="Yopish"><i class="glyphicon glyphicon-remove"></i></button>',
                        'closeButton' => '<button type="button" class="btn btn-sm btn-warning kv-editable-close" style="margin:2px 4px 0 0;" title="Yopish"><i class="glyphicon glyphicon-remove"></i></button>',
                        'templateBefore' => <<< HTML
<div class="kv-editable-form-inline" style='width:120px;'>
    {loading}
HTML
                        ,'templateAfter' => <<< HTML
    <div class="form-group">
        {buttons}{close}
    </div>
</div>
HTML
                    ]
                ],
                'hAlign' => 'middle',
                'vAlign' => 'middle',
            ],

            ['class' => 'kartik\grid\ActionColumn', 'header'=>'Amallar'],
        ],
    ]); ?>

</div>