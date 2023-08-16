<style>
    div.title h4{
        text-align:center;
    }
    div.row{
        display:flex;
        justify-content:space-between;
    }
    .row_two div.border{
        border-bottom:1px solid black;
        width:100%;
    }
    .row_two div.text_small{
        text-align:center;
    }
    .row_four{
        display:flex;
        justify-content:space-between;
        text-align:center;
    }
    .text_bold{
        font-weight:bold;
    }
    .row_four p{
        text-align:left;
    }
    .row_six{
        display:flex;
        justify-content:space-between;
    }
    .row_six div.col-md-6{
        padding:10px;
        width:100%;
        border:1px solid black;
        margin:5px
    }
    .border_bottom{
        border-bottom:1px solid black;
    }
    table{
        border-collapse:collapse;
        width:100%;
    }
    div.row_eight{
        display:flex;
        justify-content:space-around;
    }
    .row_eleven{
        display:flex;
        justify-content:space-around;
    }
    .row.imzo{
        display:flex;
        justify-content:flex-end;
    }
    thead td{
        text-align: center;
    }
    .t-right{
        text-align: right;
        white-space: nowrap;
    }
    .t-center{
        text-align: center;
    }
    div.container_fluid{
        /* margin-top:250px; */
    }
    div.row_title_one div{
        text-align:center;
    }
    div.row_title_one div.title_center{
        text-align:center;
    }
    div.row_row_one{
        display:flex;
        justify-content:space-around;
    }
    div.row_row_two p{
        text-indent: 50px;
    }
    .row_row_row div{
        text-align:center;
        font-weight:bold;
    }
    div.row_row_eleven{
        display:flex;
        justify-content:space-around;
    }
    .border{
        border-bottom:1px solid black;
        font-weight:bold;
    }
    .firm_name{
        font-weight:bold;
    }
    body{
        font-size: 14px;
    }
    td{
        font-size: 12px;
    }
</style>
<?php

use sklad\models\Organization;
?>
<script type="text/javascript">

    window.print();

</script>
<?php 
$sum = 0;
$summa = 0;

foreach ($products as $key => $item) {
    $sum = $item['cost']*$item['amount'];
    $summa+=$sum;
}
$summa = $summa;

$months = [
        '01'=>'январь',
        '02'=>'февраль',
        '03'=>'март',
        '04'=>'апрель',
        '05'=>'май',
        '06'=>'июнь',
        '07'=>'июль',
        '08'=>'август',
        '09'=>'сентябрь',
        '10'=>'октябрь',
        '11'=>'ноябрь',
        '12'=>'декабрь'
    ];
    $doc_date_day = preg_replace("/(\d{1,4})-(\d{2})-(\d{2})/","$3", $model['contract_date']);
    $doc_date_month = preg_replace("/(\d{1,4})-(\d{2})-(\d{2})/","$2", $model['contract_date']);
    $doc_date_year = preg_replace("/(\d{1,4})-(\d{2})-(\d{2})/","$1", $model['contract_date']);

    $d = preg_replace("/(\d{1,4})-(\d{2})-(\d{2})/","$3", $model['date']);
    $m = preg_replace("/(\d{1,4})-(\d{2})-(\d{2})/","$2", $model['date']);
    $y = preg_replace("/(\d{1,4})-(\d{2})-(\d{2})/","$1", $model['date']);
    // prd($doc_date_month);
    // exit;
    // $d = date('d');
    // $m = date('m');
    // $y = date('Y');
?>

<div class="container">
    <div class="row_five">
        <div class="title">
            <h4>
                СЧЕТ-ФАКТУРА № <?=$model['invoice_no']?> от <?= $d.'.'.$m.'.'.$y?> г. <br> 
                к товарно-отгрузочные документам: договор № <?=$model['contract_no']?> от <?= $doc_date_day.' '.$months[$doc_date_month].' '.$doc_date_year ?> г.
            </h4>
        </div>
    </div>
    <div class="row_six">
        <div class="col-md-6">
            <div><small>Поставщик</small> <span class="text_bold"><u><small> <?=Organization::FULL_NAME?></small></u></span></div>
            <div><small>Адрес</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><?=Organization::ADDRESS?></span></div>
            <br>
            <div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span><small><u>Индентификационный номер поставщика</u></small></span></div>
            <div><span>ИНН</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text_bold border_bottom"><?=Organization::INN?></span></div>
            <div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            <small><u>Регистрационный номер плателыщика НДС</u></small></div>
        </div>
        <div class="col-md-6">
            <div><small>Поставщик</small> <span class="text_bold"><u><small> "<?=$model['client']['name']?>"</small></u></span></div>
            <div><small>Адрес</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><?=$model['client']['address']?></span></div>
            <br>
            <div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span><small><u>Индентификационный номер покупателя</u></small></span></div>
            <div><span>ИНН</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?=$model['client']['inn']?></u><span class="text_bold border_bottom"><u></u> </span></div>
            <div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            <small><u>Регистрационный номер плателыщика НДС</u></small></div>
        </div>
    </div>
    <div class="row_seven">
        <table border>
            <thead>
            <tr>
                <td rowspan="2">Наименование товаров (работ,услуг)</td>
                <td rowspan="2">Ед.изм</td>
                <td rowspan="2">Кол-во</td>
                <td rowspan="2">Цена</td>
                <td rowspan="2">Стоимость поставки</td>
                <td colspan="2">НДС</td>
                <td rowspan="2">
                Стоим.поставки с учетом НДС
                </td>
               
            </tr>
            <tr>
                <td>Ставка %</td>
                <td>Сумма </td>
            </tr>
            </thead>
            <tr>
                <td colspan="8">
                   
                </td>
            </tr>
            <tbody>
            <?php foreach ($products as $key => $value):?>
                <tr>
                    <td><?= $value['product_id']?></td>
                    <td class="t-center">Шт</td>
                    <td class="t-center"><?= $value['amount']?></td>
                    <td class="t-right"><?= number_format($value['cost'],2,',',' ')?></td>
                    <td class="t-right"><?= number_format($value['amount'] * $value['cost'],2,',',' ')?></td>
                    <td class="t-right">Без</td>
                    <td class="t-center">НДС</td>
                    <td></td>    
                </tr>
            <?php endforeach ?>
            <tr>
                    <td><b>Всего к оплата</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="t-right"><b><?= number_format($summa, 2, ',', ' ') ?></b></td>
                    <td class="t-right"><b>Без</b></td>
                    <td class="t-center"><b>НДС</b></td>
                    <td></td>    
            </tr>
        </tbody>
        </table>
    </div>
    <div class="row_eight">
        <div class="title">
        <small>Всего отпущено на сумму:
         <strong><?= num2str($summa)?>. <br> Без НДС.</strong></small>
        </div>
    </div>
    <div class="row_eleven">
        <div class="col-md-6" style="margin-left: -120px">
            <small> Руководитель: <?=Organization::DIRECTOR?></small> <span>_________________</span>
        </div>
        <div class="col-md-6" style="margin-right: -120px">
            <small>Получил</small> &nbsp;&nbsp;&nbsp;&nbsp;<span>______________</span>
        </div>
    </div>
    <div class="row_eleven">
        <div class="col-md-4">
        </div>
        <div class="col-md-4"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<smal>подпись получателя</small>
        </div>
    </div>
  
    <div class="row_bg">
        <div><small>Главный бухгалтер: <?=Organization::BUGALTER?>__________________</small></div>
    </div>
    <div class="row_mn">
        <div><span style=""><b>М.П</b></span><span>(при наличии печати)</span></div>
    </div>
    <div class="row_last">
        <div><small>Ответственный (ая) за выполненные работы:</small></div>
    </div>
</div>