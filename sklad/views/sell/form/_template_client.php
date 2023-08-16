<div id="app">
	<!-- Klent malumotlari -->
    <section id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="color: #5A8DEE"><?=($sell)?$sell['client']['name']:'Клиент'?></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form @submit.prevent="editSell()">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label for="client_id">Клиент</label>
                                        <multiselect v-model="form.client_id"
                                			:options="clients"
	                                        :close-on-select="true"
	                                        class=""
	                                        :clear-on-select="false" placeholder="" :allow-empty="true"
	                                        select-label="" deselect-label="" selected-label=""
	                                        :taggable="true"
	                                        @tag="addClient"
	                                        tag-placeholder="Enter" tag-position="top"
	                                        label="name" track-by="">
			                            </multiselect>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="car_number">Номер машины</label>
                                        <input v-model="form.car_number"
                                              autocomplete="off"
                                              type="text"
                                              id="car_number"
                                              placeholder=""
                                              class="form-control"> <!--PAA 123-->
                                        </input>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date">Дата</label>
                                        <vuejs-datepicker
		                                    v-model="form.date"
		                                    :format="DatePickerFormat"
		                                    name="form.date"
		                                    :language="language"
		                                    input-class="form-control"
		                                    @input="formatDate"
		                                    onkeypress="return (event.charCode != 13)">
		                                </vuejs-datepicker>
                                    </div>
                                    <div class="col-md-3" v-if="role_id==2">
                                        <label for="invoice_no">Счет №</label>
                                        <input type="text" class="form-control" id="invoice_no" v-model="form.invoice_no">
                                    </div>
                                    <div class="col-md-3" v-if="role_id==2">
                                        <label for="contract_no">Дог №</label>
                                        <input type="text" class="form-control" id="contract_no" v-model="form.contract_no">
                                    </div>
                                    <div class="col-md-3" v-if="role_id==2">
                                        <label for="contract_date">Дата контракта</label>
                                        <vuejs-datepicker
                                            v-model="form.contract_date"
                                            :format="DatePickerFormat"
                                            name="form.contract_date"
                                            :language="language"
                                            input-class="form-control"
                                            @input="formatDateContract"
                                            onkeypress="return (event.charCode != 13)">
                                        </vuejs-datepicker>
                                    </div>
                                    <div class="form-group col-md-3" v-if="role_id==2">
                                        <label for="status">ПРОВЕРЕНО</label>
                                        <select class="form-control" v-model="form.status" id="status" onkeypress = "return (event.charCode != 13)">
                                            <option v-for="option in statuslar" v-bind:value="option.id">
                                                {{ option.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-1">
                                        <label for="note">Описание</label>
                                        <textarea type="text" class="form-control" id="note" v-model="form.note"></textarea>
                                    </div>

                                </div>

                                <?php require_once '_template_product.php' ?>
                                <button class="btn btn-primary"><?=($sell)?'Изменить':'Сохранить'?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Klent malumotlari -->
</div>
