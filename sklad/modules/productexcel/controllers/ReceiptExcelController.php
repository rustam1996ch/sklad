<?php


namespace sklad\modules\productexcel\controllers;

use sklad\models\Client;
use sklad\models\Connertor;
use sklad\models\Gofra;
use sklad\models\Layer;
use sklad\models\Product;
use sklad\models\ProductType;
use sklad\models\Receipt;
use sklad\models\Territory;
use sklad\models\UploadExcel;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class ReceiptExcelController extends Controller
{

    public function actionExcel()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        $model = new UploadExcel();
        $file = UploadedFile::getInstance($model, 'file');
        $errors = [];
        if (Yii::$app->request->post() && $file != null){
            $name = Yii::$app->security->generateRandomString(12).'.'.$file->extension;
            $path = Yii::$app->basePath . '/web/uploads/' . $name;
            $file->saveAs($path);

            $fileName = $path;
//            $fileName = 'uploads/2020.xlsx';
            try {
                $inputFileType = \PHPExcel_IOFactory::identify($fileName);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objExcel = \PHPExcel_IOFactory::load($fileName);
            }catch (\Exception $e){
                die('error');
            }
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            for ($row=1; $row<=$highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
                if ($row >= 1 || $row <= 7) {
                    continue;
                }

                $t = $this->productId($rowData[0][7]);
                if(isset($t) && $rowData[0][13] != 0){
                    $receipt = new Receipt();
                    $receipt->date = '2019-02-29';
                    $receipt->product_id = $t;
                    $receipt->amount = $rowData[0][13];
                    $receipt->status = 1;
                }else{
                    continue;
                }


                if ($receipt->save(false)){
                    Yii::$app->session->setFlash('success', 'Success');
                }else{
                    $errors[$row] = $rowData;
                }
            }

//            pr($errors);
        }
        return $this->render('excel', ['model' => $model, 'errors' => $errors]);
    }

    private function productId($article){
        $product = Product::find()->where(['vendor_code' => $article])->one();
        if(isset($product)){
            return $product->id;
        }
        return null;
    }

}