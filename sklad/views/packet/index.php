<?php

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use kartik\daterange\DateRangePicker;


/* @var $this yii\web\View */
/* @var $searchModel sklad\models\search\PacketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поддоны';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

app()->formatter->nullDisplay = '&mdash;';
?>


<style type="text/css">
    td.skip-export {
        position: sticky;
        right: 0px;
        background-color: #fff;
        /*z-index: 1000;*/
    }

    th.skip-export {
        position: sticky !important;
        right: 0px !important;
        background-color: #fff !important;
        /*z-index: 1000;*/
    }

    button.skip-export{
        position: sticky;
        left: 0px !important;
    }
    /*ul li {*/
    /*    position: sticky;*/
    /*    right: 0px !important;*/
    /*}*/
</style>

<div class="modal fade create-update-packet" id="create-update-packet" tabindex="false" role="dialog"
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

<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <section class="basic-select2">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <?php
                                            echo DateRangePicker::widget([
                                                'model' => $searchModel,
                                                'attribute' => 'dateRange',
                                                'value' => '',
                                                'useWithAddon' => false,
                                                'convertFormat' => true,
                                                'startAttribute' => 'dateBegin',
                                                'endAttribute' => 'dateEnd',
                                                'options' => [
                                                    'placeholder' => 'Дата',
                                                    'class' => 'form-control',
                                                    'autocomplete' => 'off',
                                                ],
                                                'pluginOptions' => [
                                                    'locale' => ['format' => 'd.m.Y'],
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
                                        <div class="col-5">
                                            <div class="form-group">
                                                <select class="select2 form-control" id="select_product">
                                                    <option value="" disabled selected hidden>Выберите продукт ...
                                                    </option>
                                                    <?php foreach ($products as $product) { ?>
                                                        <option value="<?= $product->id ?>"><?= /*$product->vendor_code . ' - ' .*/ $product->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <button type="button" id="search_btn"
                                                    class="btn btn-icon btn-outline-primary mr-1 mb-1"><i
                                                        class="bx bx-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <?php if (app()->user->identity->role_id == 3 || app()->user->identity->role_id == 4) { ?>
                                <div class="row">
                                    <div class="col-3 py-1">
                                        <button class="btn btn-secondary create-packet skip-export" style="float: left;">Добавить
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>
                            <table class="table table-hover table-striped dataex-html5-selectors table-sm table-bordered"
                                   id="packetTable">
                                <thead>
                                <tr>
                                    <th scope="col">№</th>
<!--                                    <th scope="col" class="text-center">BAR КОД</th>-->
                                    <th scope="col" class="text-center">Артикул</th>
                                    <th scope="col" class="text-center">ПРОДУКТ</th>
                                    <th scope="col" class="text-center">КОЛИЧЕСТВО</th>
                                    <th scope="col" class="text-center">ОСТАЛОСЬ</th>
                                    <th scope="col" class="text-center">Поддоны</th>
                                    <th scope="col" class="text-center">Место расположения</th>
                                    <th scope="col" class="text-center">Пользователь</th>
                                    <th scope="col" class="text-center">ДАТА</th>
                                    <th scope="col" class="text-center">ПРИМЕЧАНИЕ</th>
                                    <th scope="col" class="text-center skip-export">ДЕЙСТВИЯ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;
                                foreach ($pacets as $item) {
                                    $i++; ?>
                                    <?php if ((app()->user->identity->role_id == 1) || (app()->user->identity->role_id == 3) || (app()->user->identity->role_id == 4)) { ?>
                                        <tr>
                                            <td class="text-center"><?= $item['id'] ?></td>
<!--                                            <td class="text-center" nowrap="">-->
<!--                                                --><?php
//                                                $setTypeId = \sklad\models\Packet::generatorBarCodeId($item['id']);
//                                                $barcode = new BarcodeGenerator();
//                                                $barcode->setText($setTypeId);
//                                                $barcode->setType(BarcodeGenerator::Upca);
//                                                $barcode->setScale(2);
//                                                $barcode->setThickness(25);
//                                                $barcode->setFontSize(10);
//                                                $code = $barcode->generate();
//                                                echo '<img src="data:image/png;base64,' . $code . '" />';
//                                                ?>
<!--                                            </td>-->
                                            <td class="text-bold-500 text-center"
                                                nowrap=""><?= \sklad\models\Product::findOne($item['id'])->vendor_code ?></td>
                                            <td class="text-bold-500 text-center"
                                                nowrap=""><?= $item['productName'] ?></td>
                                            <td class="text-center"><?= $item['amount'] ?></td>
                                            <td class="text-center"><?= $item['left'] ?></td>
                                            <td class="text-center" nowrap=""><?= $item['amount_in_packet'] ?>
                                                * <?= (integer)$item['butunQismi'] ?> + <?= $item['qoldiqQismi'] ?></td>
                                            <td class="text-center"><?= ($item['space'] == 0) ? 'Буфер' : 'Склад' ?></td>
                                            <td class="text-center"><?= $item['full_name'] ?></td>
                                            <td class="text-center"><?= Yii::$app->formatter->asDate($item['date'], 'php:d.m.Y') ?></td>
                                            <td class="text-center"><?= $item['note'] ?></td>
                                            <td class="text-center skip-export">
                                                <a href="<?= \yii\helpers\Url::to(['packet/print3', 'id' => $item['id'], 'amount_in_packet' => $item['amount_in_packet'], 'butunqismi' => (integer)$item['butunQismi'], 'qoldiqqismi' => $item['qoldiqQismi'], 'full_name' => $item['full_name']]) ?>"
                                                   target="_blank"><i class="fa fa-print"></i></a>

                                                <a href="<?= \yii\helpers\Url::to(['packet/print-a4', 'id' => $item['id']]) ?>"
                                                   target="_blank"><i class="fa fa-print"></i></a>

                                                <?php if ($item['space'] == 1 && app()->user->identity->role_id == 3) { ?>
                                                    <button type="button" class="update-packet btn btn-link"
                                                            data-id="<?= $item['id'] ?>" style="display: contents"><span
                                                                class="fas fa-lg fa-pencil-alt"
                                                                style="font-size:14px;"></span></button>
                                                    <a class="label btn-link"
                                                       href="<?= \yii\helpers\Url::to(['packet/delete', 'id' => $item['id']]) ?>"
                                                       title="Delete"
                                                       data-confirm="Вы уверены, что хотите удалить этот элемент ?"
                                                       data-method="post" aria-label="Delete"><span
                                                                class="fa fa-lg fa-trash"
                                                                style="font-size:14px;"></span></a>
                                                <?php } ?>
                                                <?php if ($item['space'] == 0 && (app()->user->identity->role_id == 4 || app()->user->identity->role_id == 3)) { ?>
                                                    <button type="button" class="update-packet btn btn-link"
                                                            data-id="<?= $item['id'] ?>" style="display: contents"><span
                                                                class="fas fa-lg fa-pencil-alt"
                                                                style="font-size:14px;"></span></button>
                                                    <a class="label btn-link"
                                                       href="<?= \yii\helpers\Url::to(['packet/delete', 'id' => $item['id']]) ?>"
                                                       title="Delete"
                                                       data-confirm="Вы уверены, что хотите удалить этот элемент ?"
                                                       data-method="post" aria-label="Delete"><span
                                                                class="fa fa-lg fa-trash"
                                                                style="font-size:14px;"></span></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade text-left" id="warning-packet-modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel140" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title white" id="myModalLabel140">Маьлумот сақланди</h5>
                <button type="button" class="close closeModel" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body text-center" id="warning-packet-modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary closeModel" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    <?php ob_start() ?>

    $('body').on('click', '.update-packet', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["packet/update"]) ?>',
            data: {id: id},
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-packet').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('.create-packet').click(function () {
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["packet/create"]) ?>',
            success: function (res) {
                $('#create-update-form').html(res);
                $('.create-update-packet').modal('show');
            },
            error: function (e) {
                console.log(e);
            }
        });
    });


    $('body').on('click', '#save-packet-form', function (e) {
        e.preventDefault();
        var form = $('#save-packet');
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            success: function (res) {
                if (res.success === 1) {
                    $('.create-update-packet').modal('hide');
                    $('#create-update-form').html(res.view);

                    $.ajax({
                        type: 'post',
                        url: '<?= yii\helpers\Url::to(["packet/modal-body"]) ?>',
                        data: {packetId: res.id},
                        success: function (res) {
                            // console.log(res);
                            $("#warning-packet-modal-body").html(res);
                        },
                    });
                    $('#warning-packet-modal').modal('show');

                } else {
                    $('#create-update-form').html(res.view);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });
    $('body').on('click', '.closeModel', function () {
        location.reload();
    });

    document.getElementsByClassName('dt-buttons btn-group')[0].setAttribute('hidden', 'true');//print,copy,json and pdf buttons hidden
    document.getElementById('packetTable_filter').setAttribute('hidden', 'true'); //search input hidden

    $('body').on('click', '#product_model', function () {
        let product_id = document.getElementById('packet-product_id').value;
        if (product_id == '') {
            alert('Выберите продукт ...');
        } else {
            $.ajax({
                type: 'get',
                url: '<?= yii\helpers\Url::to(["packet/product-information"]) ?>',
                data: {product_id: product_id},
                success: function (res) {
                    $("#product_information_table").html(res);
                    $('#large').modal('show');
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

    });

    $('body').on('change', '#packet-product_id', function (e) {
        let product_id = e.target.value;
        $.ajax({
            type: 'get',
            url: '<?= yii\helpers\Url::to(["packet/product-amount-in-packet"]) ?>',
            data: {product_id: product_id},
            success: function (res) {
                let productAmountInPacket = document.getElementById('productAmountInPacket');
                productAmountInPacket.value = res.amount_in_packet;
                productAmountInPacket.setAttribute("data-product_id", product_id);
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('body').on('input', '#productAmountInPacket', function (e) {
        let product_id = e.target.getAttribute('data-product_id');
        let amountInPacket = e.target.value;
        if (product_id == '') {
            alert('Выберите продукт ...');
            e.target.value = '';
        } else {
            $.ajax({
                type: 'get',
                url: '<?= yii\helpers\Url::to(["packet/product-amount-in-packet-change"]) ?>',
                data: {product_id: product_id, amount_in_packet: amountInPacket},
                success: function (res) {
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    });

    $('body').on('click', '#search_btn', function () {
        let e = document.getElementById("select_product");
        let productId = e.options[e.selectedIndex].value;

        let dateRangeStart = document.getElementById('packetsearch-daterange-start').value;
        let dateRangeEnd = document.getElementById('packetsearch-daterange-end').value;
        let startArray = [], endArray = [], startStr = '', endStr = '', type = 0;
        startArray = dateRangeStart.split('.');
        endArray = dateRangeEnd.split('.');
        startStr = startArray[2] + '-' + startArray[1] + '-' + startArray[0];
        endStr = endArray[2] + '-' + endArray[1] + '-' + endArray[0];
        if (productId == '' && dateRangeStart != '' && dateRangeEnd != '') {
            type = 1;
        } else if (productId != '' && dateRangeStart == '' && dateRangeEnd == '') {
            type = 2;
        } else if (productId != '' && dateRangeStart != '' && dateRangeEnd != '') {
            type = 3;
        }

        if (type == 0) {
            alert("Дата ёки продуктни танланг");
        } else {
            $.ajax({
                type: 'get',
                url: '<?= yii\helpers\Url::to(["packet/product-search"]) ?>',
                data: {productId: productId, startStr: startStr, endStr: endStr, type: type},
                success: function (res) {
                    $("#packetTable").html(res);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

    });



    <?php $this->registerJs(ob_get_clean()) ?>
</script>

