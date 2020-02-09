<template>
    <div class="container">
        <form-wizard
            color="#5CDF81"
            title=""
            subtitle=""
        >
          <tab-content title="Данные плательщика">
            <div class="row">
                <div class="col-lg-6">
                  <axios-select-company></axios-select-company>
                </div>
                <div class="col-lg-6">
                  <axios-select-manager :managers="managersar"></axios-select-manager>
                </div>
            </div>
            <div class="row m-t-25">
                <div class="col-lg-6">
                  <b-form-input type="tel" placeholder="Телефон"></b-form-input>
                </div>
                <div class="col-lg-6">
                  <v-select placeholder="Тип оплаты" v-model="paytype" :options="paytypes"></v-select>
                </div>
            </div>
          </tab-content>
          <tab-content title="Данные рейса">
                Тут будут данные рейса из крана
           </tab-content>
           <tab-content title="Данные пассажира">
             Тут будет генерируемая форма пассажира зависимая от запроса в /crane
           </tab-content>
        </form-wizard>
    </div>
</template>

<script>
    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'

    export default {
        components: {
          FormWizard,
          TabContent
        },
        props:['authcompany', 'managers', 'crane'],
         data() {
           return {
            managersar: JSON.parse(this.managers),
            paytypes: [      
              {id: 0, label: 'По счёту'},
              {id: 1, label: 'По инвойсу'},
            ],
            paytype: '',
           }
       },
        mounted() {
            console.log(this.crane)
        }
    }
</script>
