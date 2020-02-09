<template>
      <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
      <div class="panel-heading">
        <div class="panel-heading-btn">
          <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" 
            data-click="panel-expand">
            <i class="fa fa-expand"></i>
          </a>
        </div>
        <h4 class="panel-title">История изменений</h4>
      </div>
      <div class="panel-body">
    <b-container fluid>
        <!-- User Interface controls -->
    
           
        <!-- Main table element -->
      <div class="col-lg-6">
         <v-select placeholder="Выберите дату изменений" @input="getItems" :options="getDates()"></v-select>  
      </div>
       <div class="col-lg-12 m-t-25">
         <b-list-group>
          <b-list-group-item v-for="(item, index) in items" :key="index">
            {{item.modelname}}
            <div class="row">

            <div class="col-lg-6">
            <div  v-for="(pitem, pindex) in item.pastdata" v-if="pitem != item.data[pindex] && pindex != 'contract_date'">
                {{pitem}}
            </div>
            </div>
            <div class="col-lg-6">
                <div  v-for="(pitem, pindex) in item.data" v-if="pitem != item.pastdata[pindex] && pindex != 'contract_date'">
                    {{pitem}}
                </div>
            </div>

            </div>
          </b-list-group-item>
         
        </b-list-group>
      </div>
        <!-- Info modal -->


    </b-container>
    </div>
    </div>
</template>

<script>


    export default {
        props:['dates'],
        data () {
            return {
                items: [],
                date: new Date(),
                selected:'',
            }
        },
        computed: {
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.label, value: f.key } })
            }
        },
        mounted() {
            console.log(JSON.parse(this.dates));
            axios
              .get('/admin/history/date/'+this.getDate(this.date))
              .then(response => (this.items = response.data.lines));
        },

        methods: {
            getDate(date){
                return date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
            },
            getDates(){
                return JSON.parse(this.dates);
            },
            getItems(data){
                var date = new Date(data);
                if(date.getFullYear() < 2019){
                    console.log("Дата не выбрана");
                }
                var th = this;
                 axios
              .get('/admin/history/date/'+this.getDate(date))
              .then(response => (th.items = response.data.lines));
            },
        
        }
    }
</script>
