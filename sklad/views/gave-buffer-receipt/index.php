<?php
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;

$this->registerJsFile(Yii::getAlias('@web') . '/js/vue/vue.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(Yii::getAlias('@web') . '/js/axios/axios.min.js', ['position' => View::POS_HEAD]);
// $this->registerJsFile(Yii::getAlias('@web') . '/js/vue.min.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(Yii::getAlias('@web') . '/js/vue/vuejs-datepicker.min.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(Yii::getAlias('@web') . '/js/vue/vue-date-picker-locale-ru.min.js', ['position' => View::POS_HEAD]);

$this->registerJsFile(Yii::getAlias('@web') . '/js/moment.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(Yii::getAlias('@web') . '/js/vue-select.js', ['position' => View::POS_HEAD]);
$this->registerCssFile(Yii::getAlias('@web') . '/js/vue/vue-select.css', ['position' => View::POS_HEAD]);
$this->registerJsFile(bu('/js/vue/vue-the-mask.min.js'), ['position' => View::POS_HEAD]);


$this->registerJsFile(bu('/js/vue/vue-multiselect.min.js'), ['position' => View::POS_HEAD]);
$this->registerCssFile(bu('/js/vue/vue-multiselect.min.css'));

$this->title = 'Получить из буфера';
$this->params['breadcrumbs'][] = $this->title;

app()->formatter->nullDisplay = '&mdash;';

?>
<div class="content-body" id="gave">
    <!--Grid options-->
    <section id="grid-options" class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div><!--class="table-responsive"-->
                            <table class="table table-bordered table-striped table-hover table-sm table-p-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Поддон <span class="text-danger">*</span></th><!--packet_id-->
                                    <th class="text-center">Товар <span class="text-danger">*</span></th><!--packet->product->name-->
                                    <th class="text-center">КОЛИЧЕСТВО <span class="text-danger">*</span></th><!--amount-->
                                    <!--<th class="text-center">Цена <span class="text-danger">*</span></th>--><!--cost-->
                                    <th class="text-center">Дата</th><!--date-->
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(row,index) in rows">
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        <input class="form-control" @input="bufferPacketId(row)" autocomplete="off" v-model="row.packet_id" onkeypress="return (event.charCode != 13)" v-on:keyup.enter="addRow(index)" :id="index">
                                        <span style="color: red">{{row.comment}}</span>
                                    </td>
                                    <td>
                                        <multiselect2 v-model="row.product_id" :options="product" :close-on-select="true"
                                                      :clear-on-select="false" placeholder="Товар" :allow-empty="false"
                                                      select-label="" deselect-label="" selected-label=""
                                                      label="productName2" track-by="productName2"></multiselect2>
                                    </td>
                                    <td>
                                        <input class="form-control" v-model="row.amount">
                                    </td>
                                    <!--<td>
                                        <input class="form-control" v-model="row.cost">
                                    </td>-->
                                    <td>
                                        <datepicker v-model="row.date" placeholder=""
                                                    :monday-first=true :bootstrap-styling="true" :required="true"
                                                    :language="datePickerLanguage" @input="dateFormat(index)"></datepicker>
                                    </td>
                                    <td class="text-center">
                                        <a type="button" href="#" @click="deleteRow(row,index)"><i class="badge-circle bx bx-trash bx bx-envelope font-medium-1"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success mt-1" @click="addRow(rows.length - 1)" style="float: right;"><i class="fa fa-plus"></i>&nbsp;&nbsp;Добавить</button>
                            <button type="button" class="btn btn-icon btn-primary mt-1" @click="postReceiptSave"><i class="bx bx-save"></i> Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script type="text/javascript">
    Vue.component('multiselect2', window.VueMultiselect.default);
    var gave = new Vue({
        el: '#gave',
        data: {
            datePickerLanguage: ru,
            rows: [{
                packet_id: '',
                product_id: '',
                amount: '',
                cost: '',
                date: "<?= date('Y-m-d') ?>",
                comment: '',
            }],
            product: <?= JSON::encode($receipts) ?>,
            validateErrMsg: '',
        },
        components: {
            datepicker: vuejsDatepicker,
        },
        methods:{
            addRow: function (index) {
                this.rows.push({
                    packet_id: '',
                    product_id: '',
                    amount: '',
                    cost: '',
                    date: "<?= date('Y-m-d') ?>",
                    comment: '',
                });
                let n = index+1;
                setTimeout(function(){
                    document.getElementById(n).focus();
                }, 0);
            },
            deleteRow: function (row, index) {
                this.rows.splice(this.rows.indexOf(row), 1);
            },
            dateFormat: function (index) {
                this.rows[index].date = moment(this.rows[index].date).format('YYYY-MM-DD');
            },
            bufferPacketId: function(row){
                if(row.packet_id.length > 0){
                    if(row.packet_id.length > 11) {
                        $.ajax({
                            url: window.baseUrl + 'gave-buffer-receipt/find-packet-id',//packet_id orqali product_id olinyapti
                            method: 'POST',
                            dataType: 'json',
                            // contentType: 'application/json',
                            data: {json: JSON.stringify(this.generateId(row.packet_id))},
                            success: function (res) {
                                if (res.booleanBuffer) {
                                    row.product_id = res.productForList;
                                    row.amount = res.productForList.amount;
                                    row.cost = res.productForList.cost;
                                    row.comment = '';
                                } else {
                                    row.product_id = '';
                                    row.amount = '';
                                    row.cost = '';
                                    row.comment = "Маълумот топилмади";
                                }
                            }
                        })
                    }
                }else{
                    row.product_id = '';
                    row.amount = '';
                    row.cost = '';
                    row.comment="Маълумот киритинг илтимос!";
                }
            },
            generateId: function(id){
                let strId = '' + id;
                let strRemove = strId.slice(1, -1);
                return parseInt(strRemove);
            },
            postReceiptSave: function () {
                if(this.validate()){
                    $.ajax({
                        url: window.baseUrl + 'gave-buffer-receipt/post-receipt',
                        method: 'POST',
                        dataType: 'json',
                        // contentType: 'application/json',
                        data: {json: JSON.stringify(this.rows)},
                        success: function (res) {
                            // console.log(res);
                            if (res.success) {
                                alert("Сохранено");
                                location.href = window.baseUrl + 'gave-buffer-receipt/index';
                            } else {
                                alert('Сақлашда хатолик');
                            }
                        }
                    }).fail(function () {
                        alert('Сақланмади');
                    })
                }else{
                    alert(this.validateErrMsg);
                }
            },
            validate: function () {
                var valid = true;
                this.validateErrMsg = '';
                if(this.rows.length == 0){
                    valid = false;
                    this.validateErrMsg = 'Буффер полияларини қўшинг';
                }else{
                    for (let i = 0; i < this.rows.length; i++) {
                        if(this.rows[i].packet_id == ''){
                            valid = false;
                            this.validateErrMsg = (i + 1) + ') Поддон майдонни тўлдиринг!';
                            break;
                        } else if(this.rows[i].product_id == ''){
                            valid = false;
                            this.validateErrMsg = (i + 1) + ') Товарни танланг!';
                            break;
                        }else if (this.rows[i].amount == ''){
                            valid = false;
                            this.validateErrMsg = (i + 1) + ') Количество майдонни тўлдиринг!';
                            break;
                        }/*else if (this.rows[i].cost == ''){
                            valid = false;
                            this.validateErrMsg = (i + 1) + ') Цена майдонни тўлдиринг!';
                            break;
                        }*/ else if (this.rows[i].date == ''){
                            valid = false;
                            this.validateErrMsg = (i + 1) + ') Датани танланг!';
                            break;
                        }
                    }
                }
                return valid;
            },
        },

    });

</script>
