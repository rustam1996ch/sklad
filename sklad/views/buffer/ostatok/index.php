<?php

use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel sklad\models\search\SellSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Буфер Остаток';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
?>



<?php //$this->beginBlock('view_actions');

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'header' => 'Тип продукта',
        'attribute' => 'product_type_name',
        'filterType' => GridView::FILTER_SELECT2,
        'vAlign' => 'middle',
        'filter' => [null => '---'] + sklad\models\ProductType::dDListProductType(),
    ],
    [
        'header' => 'Марка',
        'attribute' => 'mark',
    ],
    [
        'header' => 'Товар',
        'attribute' => 'name',
    ],
    [
        'header' => 'Остаток',
//        'attribute' => 'date',
        'pageSummary' => true,
        'vAlign' => 'middle',
        'value' => function ($model) {
            return $model['ostatok'];
        },
    ],
    [
        'header' => 'М КВ',
        'format' => ['decimal', 0],
        'noWrap' => true,
        'value' => function ($model) {
            return ($model['ostatok'] * $model['a'] * $model['b']) / 1000000;
        },
    ],


];

//$this->endBlock();

?>

<div class="sell-ostatok-product">
    <?php if (\Yii::$app->user->identity->role_id == 5 || \Yii::$app->user->identity->role_id == 2): ?>
        <div class="container row">
            <div>
                <?= Html::a('Все', ['/rasxod/ostatok-total'], ['class' => 'btn btn-primary shadow mr-1 mb-1']) ?>
            </div>
            <div>
                <?= Html::a('Склад Остаток', ['/rasxod/ostatok-product'], ['class' => 'btn btn-primary shadow mr-1 mb-1']) ?>
            </div>
        </div>
    <?php endif ?>
    <?= GridView::widget([
        'id' => 'pjax-ostatok-product',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive' => true,
        'striped' => true,
        'condensed' => true,
        'showPageSummary' => true,
        'bordered' => true,
        'hover' => true,
        'floatHeader' => true,
        'pjax' => true,
        'columns' => $gridColumns,


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
        // 'panelBeforeTemplate' => '
        //     {toolbarContainer}
        //     ' . Html::a('Все', ['/rasxod/ostatok-total'], ['class' => 'btn btn-success', 'style' => 'float: right; margin-right: 2px']) . '.' . Html::a('Склад Остаток', ['/rasxod/ostatok-product'], ['class' => 'btn btn-success', 'style' => 'float: right; margin-right: 2px']) . '

        //     {before}
        // ',
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