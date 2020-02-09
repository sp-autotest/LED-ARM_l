<template>
  <div>
  <div class="row m-t-25">
      <div class="col-lg-4"><axios-select-city @changed="setCityFrom"></axios-select-city></div>
      <div class="col-lg-4"><axios-select-city @changed="setCityTo"></axios-select-city></div>
  </div>
  <div class="row m-t-25">
      <div class="col-lg-3">
           <label for="datearrto">Дата вылета туда</label>
          <date-picker v-model="data.dateto" @dp-change="$emit('changed', data)" :config="datepickeroptionsto"></date-picker>
          </div>
      <div class="col-lg-3" v-if="tiketway == 'ROUND_TRIP'">
          <label for="datearrhere">Дата вылета обратно</label><date-picker v-model="data.datehere" @dp-change="$emit('changed', data)" :config="datepickeroptionshere"></date-picker></div>
      <div class="col-lg-1" v-if="tiketway != 'MULTI_DIRECTIONAL'" >
      <label for="adultpeople">Взрослые</label>
          <input type="number" @input="$emit('changed', data)" v-model="data.adultpeople" id="adultpeople" min="0" class="form-control "  placeholder="">
      </div>
      <div class="col-lg-1" v-if="tiketway != 'MULTI_DIRECTIONAL'">
          <label for="childrens">Дети</label><input id="childrens" v-model="data.childrens" @input="$emit('changed', data)" type="number" min="0" class="form-control "  placeholder=""></div>
      <div class="col-lg-1" v-if="tiketway != 'MULTI_DIRECTIONAL'">
          <label for="baby">Младенцы</label><input id="baby" v-model="data.baby" @input="$emit('changed', data)" type="number" min="0" class="form-control "  placeholder=""></div>
  </div>
  </div>
</template>

<script>
  import 'bootstrap/dist/css/bootstrap.css';
  // Import this component
  import datePicker from 'vue-bootstrap-datetimepicker';
  // Import date picker css
  import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
   
    export default {
        props:['tiketway', 'skey'],
        mounted() {
            //
          
        },
        data() {
           return {
              data:{
                skey: this.skey,
                baby: 0,
                childrens: 0,
                adultpeople: 1,
                dateto: new Date(),
                datehere: new Date(),
                cityfrom:[],
                cityto:[],
              },
              datepickeroptionsto: {
                format: 'YYYY-MM-DD',
                minDate: new Date(),
              },
              datepickeroptionshere: {
                format: 'YYYY-MM-DD',
                minDate: new Date(),
              }
           }
       },
       components: {
          datePicker
        },
       methods:{
          setCityFrom(data){
            this.data.cityfrom = data;
            this.$emit('changed', this.data)
          },
          setCityTo(data){
            this.data.cityto = data;
            this.$emit('changed', this.data)
          },
          setDateTo(data){
            this.data.dateto = data;
            console.log(data);
            this.$emit('changed', this.data)
          },
      },
       update(){
        this.$emit('changed', this.data);
       },
    }
</script>

<style>

</style>