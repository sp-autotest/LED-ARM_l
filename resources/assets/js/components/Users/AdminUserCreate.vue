<template>
<div class="panel panel-inverse" data-sortable-id="ui-widget-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            
        </div>
        <h4 class="panel-title">Пользователи</h4>
    </div>
    <div class="panel-body">
            
            
             <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Активен?</label>
                <div class="col-md-9">
                    <div class="switcher">
                        <input type="checkbox" name="active" :id="'switcher_checkbox_' + user.id" v-model="user.active"   value="1">
                        <label :for="'switcher_checkbox_' + user.id"></label>
                    </div>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Группа доступов</label>
                <div class="col-md-9">
                    <v-select label="name" :options="groups" v-model="usergroup"></v-select>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Компания</label>
                <div class="col-md-9">
                   <v-select label="company_name"  v-model="user.company" :filterable="false" :options="options" @search="onSearch">
                 <template slot="option" slot-scope="option">
                       
                        {{ option.company_name }}
                    </template>
                    <template slot="no-options">
      Начните вводить наименование компании
    </template>
    <template slot="selected-option" slot-scope="option">
      <div class="selected d-center">
        
       {{ option.id }} <{{ option.company_name }}>
      </div>
    </template>
                   </v-select>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Админ?</label>
                <div class="col-md-9">
                    <div class="switcher">
                        <input type="checkbox" name="is_admin" :id="'switcher_is_admin_' + user.id" v-model="user.is_admin"   value="1">
                        <label :for="'switcher_is_admin_' + user.id"></label>
                    </div>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Пол</label>
                <div class="col-md-9">
                    <div class="switcher">
                        <input type="checkbox" name="profile.sex" :id="'switcher_sex_' + user.id" v-model="user.profile.sex"   value="1">
                        <label :for="'switcher_sex_' + user.id"></label>
                    </div>
                   {{(user.profile.sex)?'M':"Ж"}}
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">E-mail</label>
                <div class="col-md-9">
                    <input type="email"  name="email" v-model="user.email" class="form-control" placeholder="Enter email" />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="valid-tooltip">Looks good!</div>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Дополнительный E-mail</label>
                <div class="col-md-9">
                    <input type="email"  name="profile.additional_email" v-model="user.profile.additional_email" class="form-control" placeholder="Enter additional email" />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="valid-tooltip">Looks good!</div>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Имя</label>
                <div class="col-md-9">
                    <input type="text"  name="profile.first_name" v-model="user.profile.first_name" class="form-control" placeholder="Enter First Name" />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="valid-tooltip">Looks good!</div>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Должность</label>
                <div class="col-md-9">
                    <input type="text"  name="profile.position" v-model="user.profile.position" class="form-control" placeholder="Enter Position" />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="valid-tooltip">Looks good!</div>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Отчество</label>
                <div class="col-md-9">
                    <input type="text"  name="profile.middle_name" v-model="user.profile.middle_name" class="form-control" placeholder="Enter Middle Name" />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="valid-tooltip">Looks good!</div>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Фамилия</label>
                <div class="col-md-9">
                    <input type="text"  name="profile.second_name" v-model="user.profile.second_name" class="form-control" placeholder="Enter Second Name" />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="valid-tooltip">Looks good!</div>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Телефон</label>
                <div class="col-md-9">
                    <input type="text"  name="profile.phone" v-model="user.profile.phone" class="form-control" placeholder="Enter Phone" />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="valid-tooltip">Looks good!</div>
                </div>
            </div>
            <div class="row form-group m-b-10">
                <label class="col-md-3 col-form-label">Дополнительный телефон</label>
                <div class="col-md-9">
                    <input type="text"  name="profile.additional_phone" v-model="user.profile.additional_phone" class="form-control" placeholder="Enter Additional Phone" />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="valid-tooltip">Looks good!</div>
                </div>
            </div>
            <b-button-group>
                <b-button variant="success" @click="submitForm">Сохранить</b-button>
            </b-button-group>
    </div>
</div>
</template>

<script>
    import Swal from 'sweetalert2'
    import 'sweetalert2/src/sweetalert2.scss'

    export default {
        data(){
            return {
                user: {
                    active: false,
                    company: {},
                    is_admin: false,
                    email: '',
                    profile: {
                        additional_email:'',
                        first_name:'',
                        middle_name:'',
                        second_name:'',
                        phone:'',
                        sex:false,
                        additional_phone:'',
                        position:'',
                    }

                },
                options: [],
                company:"",
                groups: [],
                usergroup: {}
            }
        },
        methods: {
            submitForm(){
                axios.post('/admin/users/create-user', {user:this.user, group:this.usergroup})
                .then(response => {
                    Swal.fire(
      'Выполнено!',
      'Профиль пользователя обновлён.',
      'success'
    );
                });
            }, 
        getGroups(){
         axios.get('/admin/permissions/groups-get')
              .then(response => {
                    this.groups = response.data;
                });
         },
    onSearch: function onSearch(search, loading) {
      loading(true);
      this.search(loading, search, this);
    },
    search: _.debounce(function (loading, search, vm) {
      fetch("/admin/users/companies-get?q=" +
      escape(search)).
      then(function (res) {
        res.json().then(function (json) {return vm.options = json.companies;});
        loading(false);
      });
    }, 350) },
        mounted() {
            this.getGroups();
        }
    }
</script>
