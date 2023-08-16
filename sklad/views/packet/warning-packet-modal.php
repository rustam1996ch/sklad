<?php
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
$setTypeId = \sklad\models\Packet::generatorBarCodeId($id);
$barcode = new BarcodeGenerator();
$barcode->setText($setTypeId);
$barcode->setType(BarcodeGenerator::Upca);
$barcode->setScale(2);
$barcode->setThickness(25);
$barcode->setFontSize(10);
$code = $barcode->generate();
echo '<img src="data:image/png;base64,'.$code.'" />';
?>
<br><br>
<p>
    Штрих кодни чиқариш учун
    <a href="<?= \yii\helpers\Url::to(['packet/print3','id'=>$id]) ?>" target="_blank"><i class="fa fa-print"></i></a>
    белгини босинг.
</p>