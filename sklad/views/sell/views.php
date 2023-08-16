<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model sklad\models\Sell */

$this->title = $model->client->name;
?>

<div class="row" id="table-bordered">
	<div class="col-6">
		<table class="table table-bordered mb-0 table-sm">
            <thead>
                <tr>
                    <th>КЛИЕНТ</th>
                    <th>НОМЕР МАШИНЫ</th>
                    <th>ДАТА</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                	<td class="text-bold-500"><?=$model->client->name?></td>
                    <td class="text-bold-500"><?=$model->car_number?></td>
                    <td class="text-bold-500"><?=$model->date?></td>
                </tr>
            </tbody>
        </table>
	</div>
    <div class="col-6">
        <table class="table table-bordered mb-0 table-sm">
            <thead>
                <tr>
                    <th>ИМЯ</th>
                    <th>КОЛ-ВО</th>
                </tr>
            </thead>
            <tbody>
            	<?php foreach($products as $item):?>
                <tr>
                    <td class="text-bold-500"><?=$item->product->name?></td>
                    <td><?=$item->amount?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>            
	</div>
</div>