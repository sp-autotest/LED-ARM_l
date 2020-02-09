<template>
    <v-select label="airport_name_ru" v-model="selectedCity" @input="$emit('changed', selectedCity)" :filterable="false" :options="options" @search="onSearch">
    <template slot="no-options">
      Начните вводить название города
    </template>
    <template slot="option" slot-scope="option">
      <div class="d-center">
        {{ option.airport_name_ru }}
        </div>
    </template>
    <template slot="selected-option" slot-scope="option">
      <div class="selected d-center">
        <ios-jet-icon rootClass=" green pull-left fa-1x"></ios-jet-icon>{{ option.airport_name_ru }}
      </div>
    </template>
  </v-select>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
         data() {
           return {
            options:[],
            selectedCity: {}
           }
       },
         methods: {
    onSearch(search, loading) {
      loading(true);
      this.search(loading, search, this);
    },
    search: _.debounce((loading, search, vm) => {
      fetch(
      '/axios/get/airportsbycity?q='+search).
      then(res => {
        res.json().then(json => {
          vm.options = Object.values(json.data); 
          console.log(json.data);
        });
        loading(false);
      });
    }, 350) }
    }
</script>
