<template>
    <div>
    <b-tabs content-class="mt-3">
    <b-tab title="Данные компании" active>

        <div class="row">
        <div class="col-lg-6">
        <div class="form-group">
            <label for="company_name" class="col-lg-8 control-label">Название компании</label>
            <div class="col-lg-12">
                <input id="company_name" type="text" class="form-control" name="company_name"  v-model="comob.company_name">
            </div>
        </div>
        <v-select v-model="comob.currency_company" :options="curr" label="name_ru" value="name_ru" ></v-select>
        <div class="form-group">
            <label for="resident" class="col-lg-8 control-label">Резидент РФ</label>
            <div class="col-lg-12">
                <div class="switcher checkbox-css checkbox-inline" style="    position: relative; top: 6px;">
                    <input type="checkbox" v-model="comob.resident" id="inlineCssCheckbox1"  />
                    <label for="inlineCssCheckbox1"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
          <label for="legal_company_name" class="col-lg-8 control-label">Юридическое название компании</label>
          <div class="col-lg-12">
              <input id="legal_company_name" type="text" class="form-control" name="legal_company_name" v-model="comob.legal_company_name">
             
          </div>
        </div>
        <div class="form-group">
          <label for="post_address" class="col-lg-8 control-label">Почтовый адрес</label>
          <div class="col-lg-12">
              <input id="post_address" type="text" class="form-control" name="post_address" v-model="comob.post_address">
          </div>
        </div>
        <div class="form-group">
          <label for="legal_address" class="col-lg-8 control-label">Юридический адрес</label>
          <div class="col-lg-12">
              <input id="legal_address" type="text" class="form-control" name="legal_address" v-model="comob.legal_address">
          </div>
        </div>
        
        <div class="form-group">
          <label for="phone" class="col-lg-8 control-label">Телефон</label>
          <div class="col-lg-12">
              <input id="phone" type="text" class="form-control" name="phone" v-model="comob.phone">
              
          </div>
        </div> 
         <div class="form-group">
              <label for="finance_mail" class="col-lg-8 control-label">E-mail для фин. уведомлений</label>
              <div class="col-lg-12">
                  <input id="finance_mail" type="text" class="form-control" name="finance_mail" v-model="comob.finance_mail">
                 
              </div>
        </div>  
        <div class="form-group">
          <label for="report_mail" class="col-lg-8 control-label">E-mail для отчетов</label>
          <div class="col-lg-12">
              <input id="report_mail" type="text" class="form-control" name="report_mail" v-model="comob.report_mail">
          </div>
        </div> 
        <div class="form-group">
              <label for="fax" class="col-lg-8 control-label">Факс</label>
              <div class="col-lg-12">
                  <input id="fax" type="text" class="form-control" name="fax" v-model="comob.fax">
              </div>
        </div>
        
        </div>
        <div class="col-lg-6">
            <vue-dropzone class="m-b-25" ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" :useCustomSlot=true>
                <div class="dropzone-custom-content">
                <h3 class="dropzone-custom-title">Перенесите сюда новый логотип компании</h3>
                <div class="subtitle" style="font-size: 14px;">...или кликайте сюда, чтобы выбрать его с вашего компьютера</div>
                </div>
            </vue-dropzone>
            <div class="form-group">
          <label for="city" class="col-lg-8 control-label">Город нахождения</label>
          <div class="col-lg-12">
              <input id="city" type="text" class="form-control" name="city" v-model="comob.city">
          </div>
        </div>
            <div class="form-group">
          <label for="okud" class="col-lg-8 control-label">ОКУД</label>
          <div class="col-lg-12">
              <input id="okud" type="text" class="form-control" name="okud" v-model="comob.okud">
          </div>
        </div> 
        <div class="form-group">
          <label for="inn" class="col-lg-8 control-label">ИНН</label>
          <div class="col-lg-12">
              <input id="inn" type="text" class="form-control" name="inn" v-model="comob.inn">
          </div>
        </div>
        <div class="form-group">
          <label for="okonh" class="col-lg-8 control-label">ОКОНХ</label>
          <div class="col-lg-12">
              <input id="okonh" type="text" class="form-control" name="okonh"  v-model="comob.okonh">
              
          </div>
        </div>
        <div class="form-group">
          <label for="ogrn" class="col-lg-8 control-label">ОГРН</label>
          <div class="col-lg-12">
              <input id="ogrn" type="text" class="form-control" name="ogrn"  v-model="comob.ogrn">
          </div>
        </div>
        <div class="form-group">
          <label for="kpp" class="col-lg-8 control-label">КПП</label>
          <div class="col-lg-12">
              <input id="kpp" type="text" class="form-control" name="kpp" v-model="comob.kpp">
          </div>
        </div>
        </div>
    </div>
    
    </b-tab>
    <b-tab title="Финансовые данные компании">
        <div class="row">
            <div class="col-lg-6">
        <div class="form-group">
          <label for="bank_name" class="col-md-8 control-label">Название банка</label>
          <div class="col-lg-12">
              <input id="bank_name" type="text" class="form-control" name="bank_name" v-model="comob.bank_name">

          </div>
        </div>
        <div class="form-group">
          <label for="сhecking_account" class="col-lg-8 control-label">Номер расч. счета</label>
          <div class="col-lg-12">
              <input id="сhecking_account" type="text" class="form-control" name="сhecking_account" v-model="comob.сhecking_account">
              
          </div>
        </div>
    </div><div class="col-lg-6">
        <div class="form-group">
          <label for="bik" class="col-lg-8 control-label">БИК</label>
          <div class="col-lg-12">
              <input id="bik" type="text" class="form-control" name="bik" v-model="comob.bik">
          </div>
        </div>
        <div class="form-group">
              <label for="correspondent_account" class="col-lg-8 control-label">Корреспондентский счет</label>
              <div class="col-lg-12">
                  <input id="correspondent_account" type="text" class="form-control" name="correspondent_account" v-model="comob.correspondent_account">
              </div>
          </div></div></div>
    </b-tab>
    <b-tab title="Руководитель компании">
        <div class="row">
            <div class="col-lg-6">
        <div class="form-group">
          <label for="first_name" class="col-lg-8 control-label">Имя</label>
          <div class="col-lg-12">
              <input id="first_name" type="text" class="form-control" name="first_name"  v-model="comob.first_name">
          </div>
        </div>
        <div class="form-group">
              <label for="second_name" class="col-lg-8 control-label">Отчество</label>
              <div class="col-lg-12">
                  <input id="second_name" type="text" class="form-control" name="second_name"  v-model="comob.second_name">
              </div>
        </div></div><div class="col-lg-6">
        <div class="form-group">
          <label for="third_name" class="col-lg-8 control-label">Фамилия</label>
          <div class="col-lg-12">
              <input id="third_name" type="text" class="form-control" name="third_name"  v-model="comob.third_name">
          </div>
        </div>
        <div class="form-group">
          <label for="position" class="col-lg-8 control-label">Должность</label>
          <div class="col-lg-12">
              <input id="position" type="text" class="form-control" name="position"  v-model="comob.position">
          </div>
        </div>
    </div></div>
    </b-tab>
    <b-tab title="Настройки компании">
        <div class="row">
            <div class="col-lg-6">
                <label for="managerssel" class="col-lg-8 control-label">Менеджер</label>
                 <v-select v-model="comob.manager_id" id="managerssel" :options="manags" label="second_name" value="id" ></v-select>
                 <div class="form-group">
          <label for="agreement" class="col-lg-8 control-label">Условия оплаты</label>
          <div class="col-lg-12">
              <input id="agreement" type="text" class="form-control" name="agreement"  v-model="comob.agreement">
          </div>
        </div>
        <div class="form-group">
          <label for="contract_number" class="col-lg-8 control-label">Договор №</label>
          <div class="col-lg-12">
              <input id="contract_number" type="text" class="form-control" name="contract_number"  v-model="comob.contract_number">
          </div>
        </div>
        <div class="col-lg-12">
          <label for="datearrhere">Дата договора</label><date-picker v-model="comob.contract_date"  :config="datepickeroptions"></date-picker></div>

          <div class="form-group">
            <label for="status" class="col-lg-8 control-label">Статус компании</label>
            <div class="col-lg-12">
                <div class="switcher checkbox-css checkbox-inline" style="position: relative; top: 6px;">
                    <input type="checkbox" v-model="comob.status" id="inlineCssCheckbox2"  />
                    <label for="inlineCssCheckbox2"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="limit" class="col-lg-8 control-label">Использовать лимит баланса</label>
            <div class="col-lg-12">
                <div class="switcher checkbox-css checkbox-inline" style="position: relative; top: 6px;">
                    <input type="checkbox" v-model="comob.limit" id="inlineCssCheckbox3"  />
                    <label for="inlineCssCheckbox3"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="fees_avia" class="col-lg-8 control-label">Помещать сборы в таксу Авиа</label>
            <div class="col-lg-12">
                <div class="switcher checkbox-css checkbox-inline" style="position: relative; top: 6px;">
                    <input type="checkbox" v-model="comob.fees_avia" id="inlineCssCheckbox5"  />
                    <label for="inlineCssCheckbox5"></label>
                </div>
            </div>
        </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
          <label for="commission_business" class="col-lg-8 control-label">Комиссия бизнес</label>
          <div class="col-lg-12">
              <input id="commission_business" type="text" class="form-control" name="commission_business"  v-model="comob.commission_business">
          </div>
        </div>
        <div class="form-group">
          <label for="commission_first" class="col-lg-8 control-label">Комиссия первый</label>
          <div class="col-lg-12">
              <input id="commission_first" type="text" class="form-control" name="commission_first"  v-model="comob.commission_first">
          </div>
        </div>
        <div class="form-group">
          <label for="commission_economy" class="col-lg-8 control-label">Комиссия эконом</label>
          <div class="col-lg-12">
              <input id="commission_economy" type="text" class="form-control" name="commission_economy"  v-model="comob.commission_economy">
          </div>
        </div>
        <div class="form-group">
          <label for="residue_limit" class="col-lg-8 control-label">Лимит остатка</label>
          <div class="col-lg-12">
              <input id="residue_limit" type="text" class="form-control" name="residue_limit"  v-model="comob.residue_limit">
          </div>
        </div>
        <div class="form-group">
            <label for="invoice_payment" class="col-lg-8 control-label">Возможность оплаты по счету</label>
            <div class="col-lg-12">
                <div class="switcher checkbox-css checkbox-inline" style="position: relative; top: 6px;">
                    <input type="checkbox" v-model="comob.invoice_payment" id="inlineCssCheckbox4"  />
                    <label for="inlineCssCheckbox4"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
          <label for="support_contacts" class="col-lg-8 control-label">Контакты службы поддержки</label>
          <div class="col-lg-12">
              <textarea rows="5" class="form-control" name="support_contacts" v-model="comob.support_contacts"></textarea>
          </div>
        </div>
            </div>
        </div>
    </b-tab>
   
  </b-tabs>
  <b-button @click="saveCompany(comob)">Сохранить</b-button>
</div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import 'bootstrap/dist/css/bootstrap.css';
      // Import this component
    import datePicker from 'vue-bootstrap-datetimepicker';
      // Import date picker css
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

    export default {
        props:['data', 'currencies', 'managers'],
        components: {
            vueDropzone: vue2Dropzone,
            datePicker
        },
        mounted() {
            console.log(this.comob)
        }, 
        data() {
           return {
            comob:JSON.parse(this.data),
            curr: JSON.parse(this.currencies),
            manags: JSON.parse(this.managers),
            datepickeroptions: {
                format: 'YYYY-MM-DD',
              },
            selectedcurr:'',
            dropzoneOptions: {
                  url: 'https://httpbin.org/post',
                  thumbnailWidth: 150,
                  maxFilesize: 0.5,
                  parallelUploads:1,
                  paramName:'company_logo',
                  /*maxFiles: 1,*/
                  headers: { "My-Awesome-Header": "header value" }
                },
              
           }

       },
        methods:{
            saveCompany(data){
                console.log(data);
                axios.post('/postcompanyedit', data)
                     .then(response => {console.log(response);});
            },
        }
    }
</script>
