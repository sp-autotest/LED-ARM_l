<template>
    <v-select label="company_name" placeholder="Компания-плательщик" v-model="selectedCompany" @input="$emit('changed', selectedCompany)" :filterable="false" :options="options" @search="onSearch">
    <template slot="no-options">
      Начните вводить название компании
    </template>
    <template slot="option" slot-scope="option">
      <div class="d-center">
        {{ option.company_name }}
        </div>
    </template>
    <template slot="selected-option" slot-scope="option">
      <div class="selected d-center">
       {{ option.company_name }}
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
            selectedCompany: {}
           }
       },
         methods: {
    onSearch(search, loading) {
      loading(true);
      this.search(loading, search, this);
    },
    search: _.debounce((loading, search, vm) => {
      fetch(
      '/axios/get/companies?q='+search).
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
