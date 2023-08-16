<?php
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
?>

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
        <?php if ((app()->user->identity->role_id == 3) || (app()->user->identity->role_id == 4)) { ?>
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
