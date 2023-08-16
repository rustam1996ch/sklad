<?php
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
$productInformation = \sklad\models\Packet::productInformation($id);
$setTypeId = \sklad\models\Packet::generatorBarCodeId($id);
$barcode = new BarcodeGenerator();
$barcode->setText($setTypeId);
$barcode->setType(BarcodeGenerator::Upca);
$barcode->setScale(2);
$barcode->setThickness(20);
$barcode->setFontSize(8);
$code = $barcode->generate();

$packet = \sklad\models\Packet::findOne($id);


$amount_in_packet = $packet->product->amount_in_packet;

if ($packet->left >= $amount_in_packet && $amount_in_packet > 0) {
    $butunQismi = floor($packet->left / $amount_in_packet);
} else {
    $butunQismi = 0;
}
$qoldiqQismi = $packet->left  - ($butunQismi * $amount_in_packet);

echo '<div><span style="font-size: 18px; margin-left: 85px;">' .$productInformation->vendor_code.'</span><br> ' . '<span style="font-size: 16px;">'. $productInformation->name .'</span></div>';
echo '<div><img src="data:image/png;base64,'.$code.'" /></div>';
echo '<div><span style="font-size: 16px; display: block; text-align: center;">' .$packet->left . ' шт = ' .$amount_in_packet . 'шт * ' . $butunQismi . 'упак + ' . ($qoldiqQismi != 0 ? $qoldiqQismi . 'шт' : '') .'</span></div>';
echo '<div><span style="font-size: 18px; display: block; float: right;">' . $full_name .'</span></div>';
?>
<script type="text/javascript">
    window.print();
</script>
