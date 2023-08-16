<?php
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */

$this->registerJsFile(Yii::getAlias('@web') . '/js/vue/vue.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(Yii::getAlias('@web') . '/js/axios/axios.min.js', ['position' => View::POS_HEAD]);
// $this->registerJsFile(Yii::getAlias('@web') . '/js/vue.min.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(Yii::getAlias('@web') . '/js/vuejs-datepicker.min.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(Yii::getAlias('@web') . '/js/moment.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(Yii::getAlias('@web') . '/js/vue-select.js', ['position' => View::POS_HEAD]);
$this->registerCssFile(Yii::getAlias('@web') . '/js/vue/vue-select.css', ['position' => View::POS_HEAD]);
$this->registerJsFile(bu('/js/vue/vue-the-mask.min.js'), ['position' => View::POS_HEAD]);


$this->registerJsFile(bu('/js/vue/vue-multiselect.min.js'), ['position' => View::POS_HEAD]);
$this->registerCssFile(bu('/js/vue/vue-multiselect.min.css'));

$this->title = 'Добавить Отгрузку';
$this->params['breadcrumbs'][] = ['label' => 'Отгрузки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid" style="background-color: #fff;">

    <?php require_once '_template_client.php' ?>

</div>

<script>
	Vue.component('multiselect', window.VueMultiselect.default);

    Vue.filter('numberFormat', function (value) {
        return number_format(value, 0, '.', ' ');
    })

    Vue.component('v-select', VueSelect.VueSelect)
	var app = new Vue({
		el:'#app',
		data:{
			DatePickerFormat: 'dd.MM.yyyy',
            language: {
                language: 'Ru',
                months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                monthsAbbr: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                days: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                rtl: false,
                ymd: 'yyyy-MM-dd',
                yearSuffix: ' год'
            },
            comment:'',
            clients:[],
            products:[],
            packets:[],
            statuslar:[
                {
                    "id": 1,
                    "name": "Проверено"
                },
                {
                    "id": 0,
                    "name": "Не Проверено"
                }
            ],
            status:[
                {
                    "id": 1,
                    "name": "Актив"
                },
                {
                    "id": 0,
                    "name": "Не Актив"
                },
            ],
            role_id: <?=\Yii::$app->user->identity->role_id?>,
			form:{
				id:"<?=($sell)?$sell['id']:""?>",
				date:"<?=($sell)?$sell['date']:date('Y-m-d')?>",
                contract_date:"<?=($sell)?$sell['contract_date']:date('Y-m-d')?>",
                contract_no:"<?=($sell)?$sell['contract_no']:""?>",
                invoice_no:"<?=($sell)?$sell['invoice_no']:""?>",
				car_number:"<?=($sell)?$sell['car_number']:""?>",
				note:"<?=($sell)?$sell['note']:""?>",
				client_id:<?=($client)?$client:"null"?>,
				status:"<?=($sell)?$sell['status']:0?>",
                rasxodlar: <?=$products?>
			}
		},
		components: {
            vuejsDatepicker,
        },
        created: function () {
            this.client();
            this.product();
            this.packet();
        },
        computed:{
            totalProductsAmount(){
                return this.form.rasxodlar.reduce((sum,product)=>{
                    return sum+=product.amount*1;
                },0);
            },
            totalProductsSumma(){
                return this.form.rasxodlar.reduce((sum,product)=>{
                    return sum+=product.amount*product.cost;
                },0);
            },
        },
        methods:{
            addRow: function (index) {
                this.form.rasxodlar.push({
                    id:null,
                    comment:'',
                    date:"<?=date('Y-m-d')?>",
                    amount:'',
                    status:1,
                    cost:'',
                    product_id:'',
                    packet_id:'',
                    sell_id:null,
                    note:''
                });
                this.addFocus(index);
            },
            addRow2: function (index) {
                this.form.rasxodlar.push({
                    id:null,
                    comment:'',
                    date:"<?=date('Y-m-d')?>",
                    amount:'',
                    status:1,
                    cost:'',
                    product_id:'',
                    packet_id:'',
                    sell_id:null,
                    note:''
                });
            },
            addFocus: function(index){
                let n = index+1;
                setTimeout(function(){
                    document.getElementById(n).focus();
                }, 1);
            },
            deleteRow: function (row,index) {
                if(row.id){
                    var r = confirm("Ishonchingiz komilmi?");
                    if(r==true){
                        axios.delete(window.baseUrl + 'sell-save/delete-product?id=' + row.id)
                            .then(response => {
                                this.form.rasxodlar.splice(this.form.rasxodlar.indexOf(row), 1);
                            })
                            .catch(function (error) {

                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });
                    }
                }else{
                    this.form.rasxodlar.splice(this.form.rasxodlar.indexOf(row), 1);
                }
            },
        	formatDate() {
                this.form.date = moment(this.form.date).format('YYYY-MM-DD');
            },
            formatDateContract() {
                this.form.contract_date = moment(this.form.contract_date).format('YYYY-MM-DD');
            },
            formatDates(index){
                var dateOb = new Date(this.form.rasxodlar[index].date);
                this.form.rasxodlar[index].date = moment(dateOb).format('YYYY-MM-DD');
            },
            client() {
                axios.get(window.baseUrl + 'sell-save/clients')
                    .then(response => {
                        this.clients = response.data.result;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(function () {
                    });

            },
            addClient: function (newTag) {
                $.ajax({
                    url: '<?= Url::to(['client/add'], true)?>',
                    data: {name: newTag},
                    type: 'POST',
                    dataType: 'json',
                    async: false,
                    success: function (res) {
                        if (res) {
                            clientId = res.id;

                        } else {

                            alert('Не сохранено');
                        }
                    }
                })
                if (clientId) {

                    var tag = {
                        name: newTag,
                        id: clientId
                    };

                    this.clients.push(tag);
                    this.form.client_id = tag;
                }
        	},
            product() {
                axios.get(window.baseUrl + 'sell-save/products')
                    .then(response => {
                        this.products = response.data.result;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(function () {
                    });

            },
            packet() {
                // axios.get(window.baseUrl + 'sell-save/packets')
                //     .then(response => {
                //         this.packets = response.data.result;
                //     })
                //     .catch(function (error) {
                //         console.log(error);
                //     })
                //     .finally(function () {
                //     });

            },
            packetOne(row){
                var product_price = row.product_id.price;
                row.cost = product_price;

                // axios.get(window.baseUrl + 'sell-save/packets?id='+row.product_id.id)
                //     .then(response => {
                //         this.packets = response.data.result;
                //     })
                //     .catch(function (error) {
                //         console.log(error);
                //     })
                //     .finally(function () {
                //     });
            },
            rowData(row){
                if(row.packet_id.length>0){
                    if(row.packet_id.length > 11){
                        if(this.packetIdExistsInRows(this.generateId(row.packet_id))){
                            // this.deleteRow(row,this.form.rasxodlar.length - 1);
                            this.form.rasxodlar.splice(this.form.rasxodlar.indexOf(this.form.rasxodlar.length- 1), 1);
                            this.addRow2(this.form.rasxodlar.length - 1);
                            // $("#plus_button").click();
                            // if(this.form.rasxodlar[this.form.rasxodlar.length - 1]['product_id'] == '' && this.form.rasxodlar[this.form.rasxodlar.length - 1]['packet_id'] == ''){
                            //     this.form.rasxodlar.splice(this.form.rasxodlar.indexOf(this.form.rasxodlar.length - 1), 1);
                            //     this.addRow2(this.form.rasxodlar.length - 1);
                            //     this.addFocus(this.form.rasxodlar.length - 1);
                            // }
                            if(this.form.rasxodlar[this.form.rasxodlar.length - 2]['product_id'] == '' && this.form.rasxodlar[this.form.rasxodlar.length - 2]['packet_id'] == ''){
                                this.form.rasxodlar.splice(this.form.rasxodlar.indexOf(this.form.rasxodlar.length - 1), 1);
                                this.addFocus(this.form.rasxodlar.length - 2);
                            }
                        }else{
                            axios.get(window.baseUrl + 'sell-save/packets?id='+this.generateId(row.packet_id))
                                .then(response => {
                                    if(response.data.result){
                                        row.comment="";
                                        row.product_id = response.data.result['product'];
                                        row.cost = response.data.result['product']['price'];
                                        row.amount = response.data.result['left'];
                                        // row.packet_id = this.generateId(row.packet_id);
                                    }else{
                                        row.product_id = '';
                                        row.cost = '';
                                        row.amount = '';
                                        row.comment="Маълумот топилмади";
                                    }
                                })
                                .catch(function (error) {
                                    console.log(error);
                                })
                                .finally(function () {
                                });
                            }
                    }
                }else{
                    row.product_id = '';
                    row.cost = '';
                    row.amount = '';
                    row.comment="Маълумот киритинг илтимос!";
                }
            },
            generateId: function(id){
                let strId = '' + id;
                let strRemove = strId.slice(1, -1);
                return parseInt(strRemove);
            },
            packetIdExistsInRows: function(packet_id){
                let packetIdExists = false;
                //console.log(packet_id);
                let rasxodLength = this.form.rasxodlar.length;
                let count = 0;
                for (let i = 0; i < rasxodLength; i++) {
                    //console.log(this.generateId(this.form.rasxodlar[i].packet_id))
                    if(packet_id == this.generateId(this.form.rasxodlar[i].packet_id)){
                        count++;
                    }
                }
                if(count == 2){
                    packetIdExists = true;
                }
                //console.log(packetIdExists);
                return packetIdExists;
            },
            editSell() {
                if (!this.form.id) {
                    this.postItemSell();
                } else {
                    this.updateItemSell();
                }
            },
            postItemSell() {
                    axios.post(window.baseUrl + 'sell-save/post-sell', this.form)
                        .then(response => {
                            alert("Сохранено");
                            location.href = window.baseUrl + 'sell/index';
                            // console.log(response);
                        })
                        .catch(error => {
                            alert("Saqlashda xatolik");
                            // alert(error.response.data.errors['client_id']);
                        })
                        // .then(function () {
                        //     alert('Ошибка');
                        // });
                },
            updateItemSell() {
                    axios.post(window.baseUrl + 'sell-save/put-sell', this.form)
                        .then(response => {
                            alert("Изменить");
                            location.href = window.baseUrl + 'sell/index';
                            console.log(response);
                        })
                        .catch(error => {
                            alert("Saqlashda xatolik");
                            // alert(error.response.data.errors['client_id']);
                        })
                        .then(function () {
                            // always executed
                        });
                },
            emptyRemoveItem() {
                for (let i = 0; i < this.form.rasxodlar.length; i++) {
                    if(this.form.rasxodlar[i]['packet_id'] == '' && this.form.rasxodlar[i]['product_id'] == ''){
                        this.form.rasxodlar.splice(this.form.rasxodlar.indexOf(i+1), 1);
                    }
                }
                return this.form;
            },
    	}
	})
</script>
