<template>
      <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
      <div class="panel-heading">
        <div class="panel-heading-btn">
          <a href="/admin/users/create" class="btn btn-xs btn-success">
           Создать
          </a>
          <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" 
            data-click="panel-expand">
            <i class="fa fa-expand"></i>
          </a>
        </div>
        <h4 class="panel-title">Пользователи</h4>
      </div>
      <div class="panel-body">
    <b-container fluid>
        <!-- User Interface controls -->
        <b-row>
            <b-col md="6" class="my-1">
                <b-form-group horizontal label="Фильтр" class="mb-0">
                    <b-input-group>
                        <b-form-input v-model="filter" placeholder="Поиск" />
                        <b-input-group-append>
                            <b-btn :disabled="!filter" @click="filter = ''">Очистить</b-btn>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col md="6" class="my-1">
                <b-form-group horizontal label="Сортировка" class="mb-0">
                    <b-input-group>
                        <b-form-select v-model="sortBy" :options="sortOptions">
                            <option slot="first" :value="null">-- Не указано --</option>
                        </b-form-select><b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                            <option :value="false">Вверх</option>
                            <option :value="true">Вниз</option>
                        </b-form-select>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col md="6" class="my-1">
                <b-form-group horizontal label="Направление сортировки" class="mb-0">
                    <b-input-group>
                        <b-form-select v-model="sortDirection" slot="append">
                            <option value="asc">Вверх</option>
                            <option value="desc">Вниз</option>
                            <option value="last">Последняя</option>
                        </b-form-select>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col md="6" class="my-1">
                <b-form-group horizontal label="Элементов" class="mb-0">
                    <b-form-input type="number" min="1" :options="pageOptions" v-model.number="perPage" />
                </b-form-group>
            </b-col>
        </b-row>

        <!-- Main table element -->
      <div >
          <b-table show-empty
                 stacked="md"
                 :items="getItems"
                 :fields="fields"
                 :currentPage="currentPage"
                 :per-page="perPage"
                 :filter="filter"
                 :sort-by.sync="sortBy"
                 :sort-desc.sync="sortDesc"
                 :sort-direction="sortDirection"
                 @filtered="onFiltered"
           >
             <template slot="actions" slot-scope="row">
        <b-button size="sm" @click="row.toggleDetails">
          {{ row.detailsShowing ? 'Скрыть' : 'Показать' }} профиль
        </b-button>
        <b-button size="sm" :href="'/admin/users/edit/'+row.item.id">
          Редактировать
        </b-button>
      </template>
            <template slot="row-details" slot-scope="row">
        <b-card>
            <b-list-group>
              <b-list-group-item  v-for="(value, key) in row.item.profile" :key="key">{{ $t('users.'+key) }}: {{ value }} </b-list-group-item>
            </b-list-group>

        </b-card>
      </template>
        </b-table>
      </div>
        <b-row>
            <b-col md="6" class="my-1">
                <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
            </b-col>
        </b-row>

        <!-- Info modal -->


    </b-container>
    </div>
    </div>
</template>

<script>
const items = [];


    export default {
       // props:items,
        data () {
            return {
                items: items,
               fields: [
          { key: 'profile.first_name', label: 'Имя', sortDirection: 'desc' },
          { key: 'profile.second_name', label: 'Фамилия', class: 'text-center' },
          { key: 'profile.position', label: 'Должность', class: 'text-center' },
          { key: 'profile.phone', label: 'Телефон', class: 'text-center' },
          { key: 'roles.0.name', label: 'Уровень доступа', class: 'text-center' },
          { key: 'actions', label: '' }
        ],
                currentPage: 1,
                perPage: 8,
                totalRows: 0,
                pageOptions: 8,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                modalInfo: { title: '', content: '' }
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
            console.log(this.getItems());
        },
        methods: {
            info (item, index, button) {
                this.modalInfo.title = `Заказ №: ${item.id}`
                this.modalInfo.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', 'modalInfo', button)
                console.log(this.$route);
            },
            resetModal () {
                this.modalInfo.title = ''
                this.modalInfo.content = ''
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            getItems (ctx = null) {
                // Here we don't set isBusy prop, so busy state will be handled by table itself
                //this.isBusy = true
                var query = '';
                if(ctx != null) {
                    query = '?q=' + JSON.stringify(Object.entries(ctx));
                }
                let promise = axios.get('/admin/users/get-users'+query)

                return promise.then((data) => {
                    console.log(data);
                    const items = data.data.items
                    this.totalRows = data.data.count
                    // Here we could override the busy state, setting isBusy to false
                    // this.isBusy = false
                    return(items)
                }).catch(error => {
                    // Here we could override the busy state, setting isBusy to false
                    // this.isBusy = false
                    // Returning an empty array, allows table to correctly handle busy state in case of error
                    return []
                })
            }
        }
    }
</script>
