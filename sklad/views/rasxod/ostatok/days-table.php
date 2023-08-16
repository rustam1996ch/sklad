<?php
use yii\helpers\Json;
?>
<table class="table table-sm table-p-0 table-m-0 table-bordered table-fixed table-striped">
    <thead>
    <tr>
        <th scope="col" class="row1" rowspan="2">#</th>
        <th scope="col" class="row1 left-fx1" rowspan="2">Артикул</th>
        <th scope="col" class="row1" rowspan="2">Товар</th>
        <th scope="col" class="row1" colspan="2">Остаток</th>
        <?php
        if(!empty($rows)){
            $actions = Json::decode($rows[0]['actions']);
            $i = 1;
            ?>
            <?php foreach ($actions as $key => $action):
                if($i % 3 == 1):
                    ?>
                    <th scope="col" colspan="3" class="text-center row1" style="border-right:2px solid gray"><?= Yii::$app->formatter->asDate(substr($key, 0, 10), 'php:d.m.Y') ?></th>
                <?php endif; $i++;
            endforeach;
        }?>
    </tr>
    <tr class="row5">
        <th scope="col" class="row2" >Нач</th>
        <th scope="col" class="row2" >Кон</th>
        <?php if(!empty($rows)){
            $actions = (array)Json::decode($rows[0]['actions']);
            ?>
            <?php for ($i = 0; $i < count($actions)/3; $i++) { ?>
                <th scope="col" class="row2">П</th>
                <th scope="col" class="row2">Р</th>
                <th scope="col" class="row2" style="border-right:2px solid gray">О</th>
            <?php }
        } ?>
    </tr>
    </thead>
    <tbody>
    <?php $j = 0;
    foreach ($rows as $row) {
        $j++; ?>
        <tr class="tr_ostatok">
            <td><?= $j ?></td>
            <td class="text-nowrap left-fx1"
                title="<?= $row['name'] ?>"><?= $row['vendor_code'] ?></td>
            <td class="text-nowrap"><?= $row['name'] ?></td>
            <td class="text-nowrap text-center td_ostatok"><?= app()->formatter->asDecimal($row['B1'], 0) ?></td>
            <?php
            $actions = (array)Json::decode($row['actions']);
            $B2 = end($actions);
            ?>
            <td class="text-nowrap text-center td_ostatok"><?= app()->formatter->asDecimal($B2, 0) ?></td>
            <?php $i = 1; foreach ($actions as $action) { ?>
                <td class="text-nowrap text-right" style="<?= $i % 3 == 0 ? 'border-right:2px solid gray' : ''?>"><?= app()->formatter->asDecimal($action, 0) ?></td>
                <?php $i++; } ?>
        </tr>
    <?php } ?>
    </tbody>
</table>