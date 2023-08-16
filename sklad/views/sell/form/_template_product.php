<!-- Bordered table start -->
    <h4 class="card-title" style="color: #5A8DEE">Товары</h4>
    <hr>
        <table class="table table-bordered table-sm table-p-0">
            <thead>
                <tr>
                    <th style="width:10rem">Поддон</th>
                    <th style="width: 15rem">Продукт</th>
                    <th>Кол-во</th>
                    <th v-if="role_id == 2">Цена</th>
                    <th v-if="role_id == 2" class="text-nowrap">Сумма</th>
                    <th v-if="role_id == 2">ОПИСАНИЕ</th>
                    <th>Удалять</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in form.rasxodlar">
                    <td class="text-nowrap">
                        <input type="text" class="form-control input-sm" autocomplete="off" style="width:100%"
                                               v-model="row.packet_id" @input="rowData(row)" onkeypress="return (event.charCode != 13)" v-on:keyup.enter="addRow(index)" :id="index" ref="packet_id">
                        <span style="color: red;font-size:10px">{{row.comment}}</span>
                    </td>
                    <td>
                        <multiselect v-model="row.product_id"
                            :options="products"
                            :close-on-select="true"
                            class=""
                            @input="packetOne(row)"
                            :clear-on-select="false" placeholder="" :allow-empty="true"
                            select-label="" deselect-label="" selected-label=""
                            :taggable="true"
                            tag-placeholder="Enter" tag-position="top"
                            label="name" track-by="">
                        </multiselect>
                    </td>
                    <td>
                        <input type="text" class="form-control input-sm" style="width:100%"
                                               v-model="row.amount">
                    </td>
                    <td v-if="role_id == 2">
                        <input type="text" class="form-control input-sm" style="width:100%"
                                               v-model="row.cost">
                    </td>
                    <td v-if="role_id == 2" class="text-right text-nowrap">
                        {{row.amount*row.cost | numberFormat}}
                    </td>
                    <td v-if="role_id == 2">
                        <input type="text" class="form-control input-sm" style="width:100%"
                                               v-model="row.note">
                    </td>
                    <td>
                        <button type="button" class="btn btn-link" title="УДАЛЯТЬ" v-on:click="deleteRow(row,index)"><i class="badge-circle bx bx-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <th colspan="2">Итого</th>
                    <th class="text-right">{{totalProductsAmount | numberFormat}}</th>
                    <th class="text-right" colspan="2"><!--{{totalProductsSumma | numberFormat}}--></th>
                    <th v-if="role_id == 2" colspan="4"></th>
                </tr>
            </tbody>
        </table>

<div class="form-group">
    <button type="button" class="btn btn-success mt-1" id="plus_button" v-on:click="addRow(form.rasxodlar.length - 1)"><i class="fa fa-plus"></i>&nbsp;&nbsp;Добавить</button>
</div>
<!-- Bordered table end -->
<!--<br>
{{form.rasxodlar}}
<br>-->
<!--{{form.rasxodlar.length}}
<br>-->
