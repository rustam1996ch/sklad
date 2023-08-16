<?php
namespace app\components;

use Yii;

/**
 * Description of QrCode
 *
 * @author muhammad
 */
class QrCode extends \yii\base\BaseObject {
    
    public static function getQrCodeImageUrl($text, $filename){

        include_once Yii::getAlias('@app').'/components/phpqrcode/qrlib.php';
        
        chdir(Yii::getAlias('@webroot').'/qrcode');
        \QRcode::svg($text, "{$filename}.svg");
        
        return Yii::getAlias('@web')."/qrcode/{$filename}.svg";
    }
}
