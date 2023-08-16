<?php

use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Html;

$columns = [
        ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
        [
            'attribute'=>'id',
            'pageSummary'=>true,
            'vAlign'=>'middle',
            'order'=>DynaGrid::ORDER_FIX_LEFT
        ],
        [
            'attribute'=>'name',
            'pageSummary'=>false,
            'vAlign'=>'middle',
            'order'=>DynaGrid::ORDER_FIX_LEFT
        ],
//        [
//            'attribute'=>'color',
//            'value'=>function ($model, $key, $index, $widget) {
//                return "<span class='badge' style='background-color: {$model->color}'> </span>  <code>" .
//                    $model->color . '</code>';
//            },
//            'filterType'=>GridView::FILTER_COLOR,
//            'filterWidgetOptions'=>[
//                'showDefaultPalette'=>false,
//                'pluginOptions'=>[
//                    'showPalette'=>true,
//                    'showPaletteOnly'=>true,
//                    'showSelectionPalette'=>true,
//                    'showAlpha'=>false,
//                    'allowEmpty'=>false,
//                    'preferredFormat'=>'name',
//                    'palette'=>[
//                        [
//                            "white", "black", "grey", "silver", "gold", "brown",
//                        ],
//                        [
//                            "red", "orange", "yellow", "indigo", "maroon", "pink"
//                        ],
//                        [
//                            "blue", "green", "violet", "cyan", "magenta", "purple",
//                        ],
//                    ]
//                ],
//            ],
//            'vAlign'=>'middle',
//            'format'=>'raw',
//            'width'=>'150px',
//            'noWrap'=>true
//        ],
//        [
//            'attribute'=>'publish_date',
//            'filterType'=>GridView::FILTER_DATE,
//            'format'=>'raw',
//            'width'=>'170px',
//            'filterWidgetOptions'=>[
//                'pluginOptions'=>['format'=>'yyyy-mm-dd']
//            ],
//            'visible'=>false,
//        ],
//        [
//            'attribute'=>'author_id',
//            'vAlign'=>'middle',
//            'width'=>'250px',
//            'value'=>function ($model, $key, $index, $widget) {
//                return Html::a($model->author->name, '#', [
//                    'title'=>'View author detail',
//                    'onclick'=>'alert("This will open the author page.\n\nDisabled for this demo!")'
//                ]);
//            },
//            'filterType'=>GridView::FILTER_SELECT2,
//            'filter'=>ArrayHelper::map(Author::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
//            'filterWidgetOptions'=>[
//                'pluginOptions'=>['allowClear'=>true],
//            ],
//            'filterInputOptions'=>['placeholder'=>'Any author'],
//            'format'=>'raw'
//        ],
//        [
//            'attribute'=>'buy_amount',
//            'hAlign'=>'right',
//            'vAlign'=>'middle',
//            'width'=>'100px',
//            'format'=>['decimal', 2],
//            'pageSummary'=>true
//        ],
//        [
//            'attribute'=>'sell_amount',
//            'vAlign'=>'middle',
//            'hAlign'=>'right',
//            'width'=>'100px',
//            'format'=>['decimal', 2],
//            'pageSummary'=>true
//        ],
//        [
//            'class'=>'kartik\grid\BooleanColumn',
//            'attribute'=>'status',
//            'vAlign'=>'middle',
//        ],
        ['class' => 'kartik\grid\ActionColumn', 'template' => '{view} {update} {delete}', 'contentOptions' => ['nowrap' => 'nowrap']],
        ['class'=>'kartik\grid\CheckboxColumn', 'order'=>DynaGrid::ORDER_FIX_RIGHT],
    ];

$dynagrid = DynaGrid::begin([
    'columns' => $columns,
    'theme'=>'panel-info',
    'showPersonalize'=>true,
    'storage' => 'session',
    'gridOptions'=>[
        'condensed' => true,
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'showPageSummary'=>true,
//        'floatHeader'=>true,
        'pjax'=>true,
        'responsiveWrap'=>false,
        'panel' => [
            'type' => GridView::TYPE_ACTIVE,
            'heading'=>false,
            'before' => '{summary}',
            'after' => false,
            'summaryOptions' => [
                'class' => 'float-left',
                'style' => 'display: table; height: 38px;'
            ]
        ],
//        'resetButtonOptions' => [
//            'icon' => ''
//        ],
        'summaryOptions' => [
            'class' => 'summary',
            'style' => 'display: table-cell; vertical-align:middle;'
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="fas fa-plus"></i>', ['create'], ['class' => 'btn btn-success', 'title'=>'Create']).
                Html::a('<i class="fas fa-redo"></i>', ['dynagrid'], ['data-pjax'=>0, 'class' => 'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
            '{export}',
        ],
        'exportConfig' => [
            GridView::EXCEL => [
                'label' => '&nbsp;&nbsp;Excel',
            ],
        ],
    ],
    'enableMultiSort' => true,
    'options'=>['id'=>'unit-dynagrid'] // a unique identifier is important
]);
if (substr($dynagrid->theme, 0, 6) == 'simple') {
    $dynagrid->gridOptions['panel'] = false;
}
DynaGrid::end();

?>