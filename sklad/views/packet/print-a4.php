<?php

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

/* @var $this yii\web\View */
/* @var $model app\models\Demand */

Yii::$app->formatter->nullDisplay = '';
$packet = \sklad\models\Packet::findOne($id);

$setTypeId = \sklad\models\Packet::generatorBarCodeId($id);
$barcode = new BarcodeGenerator();
$barcode->setText($setTypeId);
$barcode->setType(BarcodeGenerator::Upca);
$barcode->setScale(4);
$barcode->setThickness(20);
$barcode->setFontSize(25);
$code = $barcode->generate();

$amount_in_packet = $packet->product->amount_in_packet;

if ($packet->left >= $amount_in_packet && $amount_in_packet > 0) {
    $butunQismi = floor($packet->left / $amount_in_packet);
} else {
    $butunQismi = 0;
}
$qoldiqQismi = $packet->left  - ($butunQismi * $amount_in_packet);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <title>Печать</title>

    <style type="text/css">
        body {
            position: relative;

            margin-top: 0mm;
            margin-left: 0mm;
            margin-right: 0mm;
            margin-bottom: 0mm;
            font-weight: 500;
        }

        table {
            padding: 0;
            border-collapse: collapse;
            width: 100%;
            position: relative;
            font-family: "Times New Roman";
            font-size: 3.6mm;
            /*font-weight:bold;*/
        }

        table td {
            padding: 0;
            margin: 0;
        }

        table td div {
            padding: 2mm;
        }

        #print {
            padding: 4mm 9mm 4mm 9mm;
        }

        .thead div {
            text-align: center;
        }

        .thead {
            height: 10mm;
        }

        @media print {
            body {
                position: relative;
                /*font-weight:bold;*/
            }

            #print {
                background-color: white;
                width: 100%;
                /*position: fixed;*/
                /*                top: 0;
                                left: 0;
                                margin: 0;*/
                /*padding: 6mm;*/
                font-size: 3.2mm;
                line-height: 3.2mm;
            }

            @page {
                size: landscape
            }
        }

        .rotate-90-inverse {
            transform: rotate(-90deg);


            /* Legacy vendor prefixes that you probably don't need... */

            /* Safari */
            -webkit-transform: rotate(-90deg);

            /* Firefox */
            -moz-transform: rotate(-90deg);

            /* IE */
            -ms-transform: rotate(-90deg);

            /* Opera */
            -o-transform: rotate(-90deg);

            /* Internet Explorer */
            filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
        }
    </style>

    <script type="text/javascript">window.print();</script>
</head>
<body>

<div id="print" style="position:relative; background-color: white; height:208mm; width: 121mm; float:left;">

</div>

<div id="print" style="position:relative; background-color: white; height:208mm; width: 121mm; float:left; padding-left:8mm; padding-right: 2mm;">


    <div style="height: 60mm; border: 0.1mm solid black;">


        <div style="height: 100%; display: table; text-align: center; width: 100%;">
            <div style="display: table-cell; vertical-align: middle; font-size: 16mm; font-weight: bold;">
                <?= $packet->id ?>
            </div>
        </div>

    </div>

    <div style="height: 140mm;">

        <table border="1" style="height: 100%;">

            <tr>
                <td colspan="9">

                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <div>Дата</div>
                            </td>
                            <td style="text-align: right;">
                                <div><?= app()->formatter->asDatetime($packet->date) ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Бригадир</div>
                            </td>
                            <td style="text-align: right;">
                                <div><?= $packet->user->full_name ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Наименование</div>
                            </td>
                            <td style="text-align: right;">
                                <div><?= $packet->product->name ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Тип картона</div>
                            </td>
                            <td style="text-align: right;">
                                <div><?= $packet->product->mark ?>; (<?= $packet->product->layersInline ?>
                                    ); <?= $packet->product->gofrasInline ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Размеры</div>
                            </td>
                            <td style="text-align: right;">
                                <div><?= $packet->product->dimensions ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Поддон №</div>
                            </td>
                            <td style="text-align: right;">
                                <div><?= $packet->id ?></div>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
            <tr style="height: 40mm;">
                <td colspan="1" style="width: 7mm" class="rotate-90-inverse">Артикул</td>
                <td colspan="8">
                    <div style="text-align: center; font-size: 25mm; font-weight: bold; text-decoration: underline;"><?= $packet->product->vendor_code ?></div>
                </td>
            </tr>
            <tr style="height: 40mm;">
                <td colspan="9" style="padding: 0;">
                    <div style="text-align: center; padding: 0;"><img src="data:image/png;base64,<?= $code ?>"/></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="vertical-align: bottom;">
                    <div style="width: 19mm;">Количество</div>
                </td>
                <td colspan="6" style="vertical-align: middle;">
                    <div style="text-align: center; width: 60mm;">
                        <?php if ($amount_in_packet && $butunQismi > 0): ?>
                            (<span style=""><?= $amount_in_packet . 'шт * ' . $butunQismi . 'упак' . ($qoldiqQismi != 0 ? ' + '.$qoldiqQismi . 'шт' : '') ?></span>)
                        <?php endif; ?>

                        <span style="font-size: 10mm; font-weight: bold;"><?= $packet->left ?></span>
                    </div>
                </td>
                <td colspan="1" style="vertical-align: bottom;">
                    <div style="width: 14mm;">шт</div>
                </td>
            </tr>

        </table>


    </div>

</div>


</body>
</html>
