<?php


namespace sklad\modules\productexcel\controllers;

use sklad\models\Client;
use sklad\models\Connertor;
use sklad\models\Gofra;
use sklad\models\Layer;
use sklad\models\Product;
use sklad\models\ProductType;
use sklad\models\Territory;
use sklad\models\UploadExcel;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class ProductExcelController extends Controller
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
                if ($row == 1 || $row == 2 || $row == 3) {
                    continue;
                }

                if ($rowData[0][1] == '' || $rowData[0][3] == '' || $rowData[0][4] == ''){
                    $errors[$row] = $rowData;
                    continue;
                }

                $client_id = $this->clientIdFind(ucfirst(strtolower($rowData[0][1])));

                $product = new Product();
                $product->product_type_id = $this->productTypeIdFind(ucfirst(strtolower($rowData[0][3])),$client_id);
                $product->territory_id = ($rowData[0][2] == '') ? null : $this->territoryIdFind($rowData[0][2]);
                $product->name = $rowData[0][4];
                $product->mark = $rowData[0][5];
                $product->x = $rowData[0][6];
                $product->y = $rowData[0][7];
                $product->z = $rowData[0][8];
                $product->unit_id = 1;
                $product->a = $rowData[0][9];
                $product->b = $rowData[0][10];
                $product->fraction = $this->fractionSearch($rowData[0][12]);

                $product->layer1_id = $this->layerIdFind($rowData[0][13]);
                $product->layer2_id = $this->layerIdFind($rowData[0][14]);
                $product->layer3_id = $this->layerIdFind($rowData[0][15]);
                $product->layer4_id = $this->layerIdFind($rowData[0][16]);
                $product->layer5_id = $this->layerIdFind($rowData[0][17]);

                $product->gofra1_id = $this->gofraIdFind($rowData[0][18]);
                $product->gofra2_id = $this->gofraIdFind($rowData[0][19]);

                $product->weight_gofra = ($rowData[0][20] == '') ? null : $rowData[0][20];
                $product->connertor_id = ($rowData[0][21] == '') ? null : $this->connertorIdFind(ucfirst(strtolower($rowData[0][21])));
                $product->point_connector = ($rowData[0][22] == '') ? null : $rowData[0][22];
                $product->price = $rowData[0][23];
                $product->vendor_code = $rowData[0][29];

                if ($product->save(false)){
                    Yii::$app->session->setFlash('success', 'Success');
                }else{
                    $errors[$row] = $rowData;
                }
            }

//            pr($errors);
        }
        return $this->render('excel', ['model' => $model, 'errors' => $errors]);
    }

    private function clientIdFind($str){
        $client = Client::find()->where(['name' => $str])->one();
        if(isset($client)){
            return $client->id;
        }else{
            $model = new Client();
            $model->name = $str;
            $model->save(false);
            return $model->id;
        }
    }

    private function productTypeIdFind($str,$client_id){
//        if($str == ''){
//            return null;
//        }
        $productType = ProductType::find()->where(['name' => $str])->one();
        if(isset($productType)){
            return $productType->id;
        }else{
            $model = new ProductType();
            $model->name = $str;
            $model->client_id = $client_id;
            $model->save();
            return $model->id;
        }
    }

    private function territoryIdFind($str){
        $territory = Territory::find()->where(['name' => $str])->one();
        if(isset($territory)){
            return $territory->id;
        }else{
            $model = new Territory();
            $model->name = $str;
            $model->save(false);
            return $model->id;
        }
    }

    private function connertorIdFind($str){
        $connertor = Connertor::find()->where(['name' => $str])->one();
        if(isset($connertor)){
            return $connertor->id;
        }else{
            $model = new Connertor();
            $model->name = $str;
            $model->save(false);
            return $model->id;
        }
    }

    private function gofraIdFind($str){
        if($str == ''){
            return null;
        }
        $gofra = Gofra::find()->where(['name' => $str])->one();
        if(isset($gofra)){
            return $gofra->id;
        }else{
            $model = new Gofra();
            $model->name = $str;
            $model->save(false);
            return $model->id;
        }
    }

    private function layerIdFind($str){
        if($str == ''){
            return null;
        }
        $layer = Layer::find()->where(['name' => $str])->one();
        if(isset($layer)){
            return $layer->id;
        }else{
            $model = new Layer();
            $model->name = $str;
            $model->save(false);
            return $model->id;
        }
    }

    private function fractionSearch($str){
        if($str == '0.16666666666667'){
            $fraction = '1/6';
        }elseif ($str == '0.33333333333333' || $str == '0.333333333333333' || $str == '0.3333333333333' || $str == '0.333333333333' || $str == '0.33333333333' || $str == '0.3333333333' || $str == '0.333333333' || $str == '0.33333333' || $str == '0.3333333' || $str == '0.333333' || $str == '0.33333' || $str == '0.3333' || $str == '0.333' || $str == '0.33' || $str == '0.3'){
            $fraction = '1/3';
        }elseif ($str == '0.25'){
            $fraction = '1/4';
        }elseif ($str == '0.5'){
            $fraction = '1/2';
        }elseif ($str == '0.2'){
            $fraction = '1/5';
        }elseif ($str == '0.14285714285714'){
            $fraction = '1/7';
        }elseif ($str == '0.125'){
            $fraction = '1/8';
        }elseif ($str == '0.11111111111111'){
            $fraction = '1/9';
        }elseif ($str == '0.041666666666667'){
            $fraction = '1/24';
        }elseif ($str == '0.066666666666667'){
            $fraction = '1/15';
        }else{
            $fraction = $str;
        }
        return $fraction;
    }

//    function excelToDate($input)
//    {
//        $output=($input-25569)*86400;
//        $output=$output-date('Z',$output);
//        return date('Y-m-d', $output);
//    }

}
