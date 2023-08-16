<table class="table table-bordered table-striped table-sm table-hover">
    <tbody>
    <tr>
        <th class="text-nowrap" scope="row">ИМЯ</th>
        <td colspan="5"><?= $product->name ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">КАТЕГОРИЯ</th>
        <td colspan="5"><?= $product->productType->name ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">АРТИКУЛ</th>
        <td colspan="5"><?= $product->vendor_code ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">ЕДИНИЦА ИЗМЕРЕНИЯ</th>
        <td colspan="5"><?= $product->unit->name ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">МАРКА</th>
        <td colspan="5"><?= $product->mark ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">ШИРИНА</th>
        <td colspan="5"><?= $product->x ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">ДЛИНА</th>
        <td colspan="5"><?= $product->y ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">ВЫСОТА</th>
        <td colspan="5"><?= (isset($product->z)) ? $product->z : '' ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">Длина заготовки</th>
        <td colspan="5"><?= $product->a ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">Ширина заготовки</th>
        <td colspan="5"><?= $product->b ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">М КВ</th>
        <td colspan="5"><?= (isset($product->mkv)) ? $product->mkv : '' ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">СТОИМОСТЬ</th>
        <td colspan="5"><?= (isset($product->cost)) ? $product->cost : '' ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">ЦЕНА</th>
        <td colspan="5"><?= (isset($product->price)) ? $product->price : '' ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">1 слой</th>
        <td colspan="5"><?= (isset($product->layer1_id)) ? $product->layer1->name : ''; ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">2 слой</th>
        <td colspan="5"><?= (isset($product->layer2_id)) ? $product->layer2->name : ''; ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">3 слой</th>
        <td colspan="5"><?= (isset($product->layer3_id)) ? $product->layer3->name : ''; ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">4 слой</th>
        <td colspan="5"><?= (isset($product->layer4_id)) ? $product->layer4->name : ''; ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">5 слой</th>
        <td colspan="5"><?= (isset($product->layer5_id)) ? $product->layer5->name : ''; ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">Соед</th>
        <td colspan="5"><?= (isset($product->connertor_id)) ? $product->connertor->name : '' ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">Весь загатовки</th>
        <td colspan="5"><?= $product->weight_gofra ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">Точка соед</th>
        <td colspan="5"><?= $product->point_connector ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">ПЛОЩАДЬ ЗАГОТОВКИ</th>
        <td colspan="5"><?= app()->formatter->asDecimal(($product->a * $product->b) / 1000000, 2) ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">Тип гофры 1</th>
        <td colspan="5"><?= (isset($product->gofra1_id)) ? $product->gofra1->name : ''; ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">Тип гофры 2</th>
        <td colspan="5"><?= (isset($product->gofra2_id)) ? $product->gofra2->name : ''; ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">ТЕРРИТОРИЯ</th>
        <td colspan="5"><?= (isset($product->territory_id)) ? $product->territory->name : ''; ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">СТАТУС</th>
        <td colspan="5"><?= ($product->status == 1) ? 'Актив' : 'Неактив' ?></td>
    </tr>
    <tr>
        <th class="text-nowrap" scope="row">Количество в упаковки</th>
        <td colspan="5"><?= (isset($product->amount_in_packet)) ? $product->amount_in_packet : ''; ?></td>
    </tr>
    </tbody>
</table>
