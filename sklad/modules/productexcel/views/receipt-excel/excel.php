<?php

use yii\helpers\Html;
use \yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Импортировать Excel';
//$this->params['breadcrumbs'][] = ['label' => 'V Protocols', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vprotocol-create container">

    <?php //pr($errors);?>
    <?php if (!empty($errors)) :?>
        <h2 class="text-center">Информация ниже не добовлена</h2>
        <table class="table table-bordered table-hover">
            <?php foreach ($errors as $error) {
                echo '<tr>';
                echo '<td>'. $error[0][1] .'</td>';
                echo '<td>'. $error[0][2] .'</td>';
                echo '<td>'. $error[0][3] .'</td>';
                echo '<td>'. $error[0][4] .'</td>';
//            echo $error[0][1].' '.$error[0][2].' '.$error[0][3].' '.$error[0][4].'<br>';
                echo '</tr>';
            }
            ?>
        </table>
    <?php endif;?>

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']])?>

    <?= $form->field($model, 'file')->fileInput()?>

    <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end()?>

</div>
