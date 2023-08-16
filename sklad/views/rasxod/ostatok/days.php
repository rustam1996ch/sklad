<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel sklad\models\search\OstatokDaysProductSearch */
/** @var array $rows */

$this->title = 'Склад остаток день';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['rasxod/ostatok-days2']];

app()->formatter->nullDisplay = '&mdash;';
?>
<style type="text/css">
    .table-responsive {
        position: sticky;
    }

    .table-responsive table thead th.row1 {
        border-bottom: solid #ddd;
        position: sticky;
        top: 0;
        background-color: #ddd;
        z-index: 1001;
        /*box-shadow: 0 0 10px 5px gray;*/
    }

    .table-responsive table thead th.row2 {
        border-bottom: solid #ddd;
        position: sticky;
        top: 3%;
        background-color: #ddd;
        z-index: 1001;
        /*box-shadow: 0 0 10px 5px gray;*/
    }

    .table-responsive table thead th.row3 {
        border-bottom: solid #ddd;
        position: sticky;
        top: 8%;
        background-color: #ddd;
        z-index: 1001;
        /*box-shadow: 0 0 10px 5px gray;*/
    }

    .table-responsive table thead th.left-fx1 {
        position: sticky;
        left: 0px;
        background-color: #ddd;
        z-index: 1002;
    }

    .table-responsive table thead th.left-fx2 {
        position: sticky;
        left: 25%;
        background-color: #ddd;
        z-index: 1002;
    }

    .table-responsive table thead th.left-fx3 {
        position: sticky;
        left: 23%;
        background-color: #ddd;
        z-index: 1002;
    }

    .table-responsive table tbody td.left-fx1 {
        position: sticky;
        left: 0px;
        background-color: #fff;
        z-index: 1000;
    }

    .table-responsive table tbody td.left-fx2 {
        position: sticky;
        left: 15%;
        background-color: #fff;
        z-index: 1000;
    }

    .table-responsive table tbody td.left-fx3 {
        position: sticky;
        left: 23%;
        background-color: #fff;
        z-index: 1000;
    }

</style>
<div class="report-r4">

    <div class="row">
        <div class="col-md-3">
            <?php
            echo "<label for='monthsearch-productname'>Дата</label>";
            echo DateRangePicker::widget([
                'model' => $searchModel,
                'attribute' => 'date',
                'value' => '',
                'useWithAddon' => false,
                'convertFormat' => false,
                'startAttribute' => 'date1',
                'endAttribute' => 'date2',
                'pluginOptions' => [
                    'locale' => ['format' => 'YYYY-MM-DD'],
                    'separator' => ' - ',
                    'opens' => 'right',
                    'alwaysShowCalendars' => true,
                    'showCustomRangeLabel' => false,
                    'ranges' => [
                        'Сегодня' => ["moment().startOf('day')", "moment().endOf('day')"],
                        'Вчера' => ["moment().startOf('day').subtract(1,'days')", "moment().endOf('day').subtract(1,'days')"],
                        'Последние 7 дней' => ["moment().startOf('day').subtract(6, 'days')", "moment().endOf('day')"],
                        'Последние 30 дней' => ["moment().startOf('day').subtract(29, 'days')", "moment().endOf('day')"],
                        'Этот месяц' => ["moment().startOf('month')", "moment().endOf('month')"],
                        'Прошлый месяц' => ["moment().subtract(1, 'month').startOf('month')", "moment().subtract(1, 'month').endOf('month')"]
                    ]
                ]
            ]);
            ?>
        </div>
        <div class="col-md-2">
            <br>
            <button type="button" id="search-btn" class="btn btn-success glow mr-1 mb-1"><i class="bx bx-search"></i>Филтер
            </button>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-2 text-right">
            <br>
            <button id="excel-export" class="btn btn-info mr-1 mb-1">EXCEL</button>
        </div>
    </div>
    <div class="content-body"><!-- card actions section start -->
        <section id="card-actions"> <!-- Info table about action starts -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- <h4 class="card-title">Card Actions </h4> -->
                            <a class="heading-elements-toggle">
                                <i class='bx bx-dots-vertical font-medium-3'></i>
                            </a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <fieldset>
                                            <div class="checkbox">
                                                <input type="checkbox" class="checkbox-input" id="checkbox2" checked>
                                                <label for="checkbox2">Филтер</label>
                                            </div>
                                        </fieldset>
                                    </li>
                                    <li>
                                        <a data-action="collapse">
                                            <i class="bx bx-chevron-down"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-action="expand">
                                            <i class="bx bx-fullscreen"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-action="reload">
                                            <i class="bx bx-revision"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-action="close">
                                            <i class="bx bx-x"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive" id="table-responsive"
                                             style="overflow:scroll; width: 100%;height: 100vh;">
                                            <table class="table table-sm table-p-0 table-m-0 table-bordered table-fixed table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col" class="row1" rowspan="2">#</th>
                                                    <th scope="col" class="row1 left-fx1" rowspan="2">Артикул</th>
                                                    <th scope="col" class="row1" rowspan="2">Товар</th>
                                                    <th scope="col" class="row1" colspan="2">Остаток</th>
                                                    <?php
                                                    if(!empty($rows)){
                                                        $actions = Json::decode($rows[0]['actions']);
                                                        $i = 1;
                                                        ?>
                                                        <?php foreach ($actions as $key => $action):
                                                            if($i % 3 == 1):
                                                            ?>
                                                            <th scope="col" colspan="3" class="text-center row1" style="border-right:2px solid gray"><?= Yii::$app->formatter->asDate(substr($key, 0, 10), 'php:d.m.Y') ?></th>
                                                        <?php endif; $i++;
                                                        endforeach;
                                                    }?>
                                                </tr>
                                                <tr class="row5">
                                                    <th scope="col" class="row2" >Нач</th>
                                                    <th scope="col" class="row2" >Кон</th>
                                                    <?php if(!empty($rows)){
                                                        $actions = (array)Json::decode($rows[0]['actions']);
                                                        ?>
                                                        <?php for ($i = 0; $i < count($actions)/3; $i++) { ?>
                                                            <th scope="col" class="row2">П</th>
                                                            <th scope="col" class="row2">Р</th>
                                                            <th scope="col" class="row2" style="border-right:2px solid gray">О</th>
                                                        <?php }
                                                    } ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $j = 0;
                                                foreach ($rows as $row) {
                                                    $j++; ?>
                                                    <tr class="tr_ostatok">
                                                        <td><?= $j ?></td>
                                                        <td class="text-nowrap left-fx1"
                                                            title="<?= $row['name'] ?>"><?= $row['vendor_code'] ?></td>
                                                        <td class="text-nowrap"><?= $row['name'] ?></td>
                                                        <td class="text-nowrap text-center td_ostatok"><?= app()->formatter->asDecimal($row['B1'], 0) ?></td>
                                                        <?php
                                                        $actions = (array)Json::decode($row['actions']);
                                                        $B2 = end($actions);
                                                        ?>
                                                        <td class="text-nowrap text-center td_ostatok"><?= app()->formatter->asDecimal($B2, 0) ?></td>
                                                        <?php $i = 1; foreach ($actions as $action) { ?>
                                                            <td class="text-nowrap text-right" style="<?= $i % 3 == 0 ? 'border-right:2px solid gray' : ''?>"><?= app()->formatter->asDecimal($action, 0) ?></td>
                                                        <?php $i++; } ?>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- // card-actions section end -->
    </div>
</div>

<script type="text/javascript">
    <?php ob_start() ?>

    $('body').on('click', '#search-btn', function (e) {
        let dateRangeStart = document.getElementById('ostatokdaysproductsearch-date-start').value;
        let dateRangeEnd = document.getElementById('ostatokdaysproductsearch-date-end').value;
        let startArray = [], endArray = [], startStr = '', endStr = '';
        startArray = dateRangeStart.split('-');
        endArray = dateRangeEnd.split('-');
        startStr = startArray[0] + '-' + startArray[1] + '-' + startArray[2];
        endStr = endArray[0] + '-' + endArray[1] + '-' + endArray[2];

        var params = {
            OstatokDaysProductSearch: {
                date1: startStr,
                date2: endStr,
            }
        }

        top.location.href = '<?= yii\helpers\Url::to(['rasxod/ostatok-days2']) ?>' + '?' + $.param( params )

    });



    $('body').on('click', '#checkbox2', function (e) {
        let dateRangeStart = document.getElementById('ostatokdaysproductsearch-date-start').value;
        let dateRangeEnd = document.getElementById('ostatokdaysproductsearch-date-end').value;
        let startArray = [], endArray = [], startStr = '', endStr = '';
        startArray = dateRangeStart.split('-');
        endArray = dateRangeEnd.split('-');
        startStr = startArray[0] + '-' + startArray[1] + '-' + startArray[2];
        endStr = endArray[0] + '-' + endArray[1] + '-' + endArray[2];

        let skipEmpties;
        if(e.target.checked)
            skipEmpties = 1;
        else
            skipEmpties = 0;
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(['rasxod/ajax-ostatok-days']) ?>',
            data: {startDate: startStr, endDate: endStr,skipEmpties: skipEmpties},
            success: function (res) {
                // console.log(res)
                $("#table-responsive").html(res);
            },
            error: function (e) {
                // console.log(e);
            }
        });

    });

    $('body').on('click', '#excel-export', function () {
        write_to_excel('table-responsive');
    });

    function write_to_excel(tableID) {
        TableToExcel.convert(document.getElementById(tableID));
    }

    <?php $this->registerJs(ob_get_clean()) ?>
</script>
