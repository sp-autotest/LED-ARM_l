<template>
    <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
      <div class="panel-heading">
        <div class="panel-heading-btn">
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
                <b-form-group horizontal label="Filter" class="mb-0">
                    <b-input-group>
                        <b-form-input v-model="filter" placeholder="Поиск" />
                        <b-input-group-append>
                            <b-btn :disabled="!filter" @click="filter = ''">Clear</b-btn>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col md="6" class="my-1">
                <b-form-group horizontal label="Sort" class="mb-0">
                    <b-input-group>
                        <b-form-select v-model="sortBy" :options="sortOptions">
                            <option slot="first" :value="null">-- none --</option>
                        </b-form-select><b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                            <option :value="false">Asc</option>
                            <option :value="true">Desc</option>
                        </b-form-select>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col md="6" class="my-1">
                <b-form-group horizontal label="Sort direction" class="mb-0">
                    <b-input-group>
                        <b-form-select v-model="sortDirection" slot="append">
                            <option value="asc">Asc</option>
                            <option value="desc">Desc</option>
                            <option value="last">Last</option>
                        </b-form-select>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col md="6" class="my-1">
                <b-form-group horizontal label="Per page" class="mb-0">
                    <b-form-input type="number" min="1" :options="pageOptions" v-model.number="perPage" />
                </b-form-group>
            </b-col>
        </b-row>

    <!-- Main table element -->
    <b-table
      show-empty
      stacked="md"
      :items="items"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      :sort-direction="sortDirection"
      @filtered="onFiltered"
    >
      <template slot="email" slot-scope="row">
        <a :href="'/admin/users/show/' + row.item.id">{{row.item.email}}</a>
      </template>

      <template slot="active" slot-scope="row">
        {{ row.value ? 'Да :)' : 'Нет :(' }}
      </template>
      <template slot="is_admin" slot-scope="row">
        {{ row.value ? 'Да :)' : 'Нет :(' }}
      </template>

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

    <b-row>
      <b-col md="6" class="my-1">
        <b-pagination
          :total-rows="totalRows"
          :per-page="perPage"
          v-model="currentPage"
          class="my-0"
        />
      </b-col>
    </b-row>

    <!-- Info modal -->
    <b-modal id="modalInfo" @hide="resetModal" :title="modalInfo.title" ok-only>
      <pre>{{ modalInfo.content }}</pre>
    </b-modal>
  </b-container>
      </div>
    </div>
</template>

<script>
  const items = []


    export default {
         data() {
      return {
        items: this.getUsers(),
        fields: [
          { key: 'email', label: 'E-mail', sortable: true, sortDirection: 'desc' },
          { key: 'created_at', label: 'Зарегистрирован', sortable: true, class: 'text-center' },
          { key: 'active', label: 'Активен?' },
          { key: 'is_admin', label: 'Админ?' },
          { key: 'actions', label: 'Actions' }
        ],
        currentPage: 1,
        perPage: 10,
        totalRows: 0,
        pageOptions: [10, 25, 50],
        sortBy: null,
        sortDesc: false,
        sortDirection: 'asc',
        filter: null,
        modalInfo: { title: '', content: '' }
      }
    },
    computed: {
      sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
          })
      }
    },
    methods: {
      info(item, index, button) {
        this.modalInfo.title = `Row index: ${index}`
        this.modalInfo.content = JSON.stringify(item, null, 2)
        this.$root.$emit('bv::show::modal', 'modalInfo', button)
      },
      resetModal() {
        this.modalInfo.title = ''
        this.modalInfo.content = ''
      },
      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },
      getUsers (ctx = null) {
        console.log(ctx);
        var query = '';
                if(ctx != null) {
                    query = '?q=' + JSON.stringify(Object.entries(ctx));
                }
        var th = this;
            axios.get('/admin/users/get-users'+query)
              .then(response => {
                    this.items = response.data.items;
                    this.totalRows = response.data.count
                });
      }
    }
  }
</script>
