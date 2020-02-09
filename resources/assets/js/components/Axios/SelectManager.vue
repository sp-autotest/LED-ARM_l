<template>
    <v-select label="second_name" placeholder="Менеджер компании" v-model="selectedCompany" @input="$emit('changed', selectedCompany)" :options="managers">
    <template slot="option" slot-scope="option">
      <div class="d-center">
        {{ option.first_name }}{{ option.second_name }}
        </div>
    </template>
    <template slot="selected-option" slot-scope="option">
      <div class="selected d-center">
       {{ option.first_name }}{{ option.second_name }}
      </div>
    </template>
  </v-select>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props:['managers'],
         data() {
           return {
            selectedCompany: {}
           }
       },
         methods: {
         }
    }
</script>
