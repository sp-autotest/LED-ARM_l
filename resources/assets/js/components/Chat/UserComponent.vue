<template>
     <div class="col-lg-3" id="contact-list">
    <a href="#modal-create-chat" class="btn btn-sm btn-success " data-toggle="modal">Создать чат</a>
    <b-list-group class="my-3 conversations">
        <b-list-group-item key="system_message" v-bind:variant="'system_message' == activeconversation?'success':''">
          
            <a href="javascript:;" @click="$emit('selectedconversation', 'system_message_'+authuser)">
                 <div class="row">
                <div class="contact-avatar">
                     <i class="fas fa-lg fa-fw m-r-10 fa-comment"></i>
                </div>
                <span>System Messages</span></div>
            </a>
        </b-list-group-item>
        <b-list-group-item  v-for="conversation in conversations" v-bind:variant="conversation.id == activeconversation?'success':''" :key="conversation.id"> 
            <a  href="javascript:;" @click="$emit('selectedconversation', conversation.id)">
                <div class="row">
                <div class="contact-avatar">
                    <i class="fas fa-lg fa-fw m-r-10 fa-comment"></i>
                </div>
                <span>{{conversation.name}}</span>
            </div>
            </a>
        </b-list-group-item>

</b-list-group>

                    <div class="modal fade " id="modal-create-chat"  aria-modal="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Создать чат</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <v-select label="email" :filterable="false" :options="options" @search="getUsers" multiple v-model="selectedUser">
                                                <template slot="option" slot-scope="option">
                                                    {{ showName(option) }} 
                                                </template>

                                            </v-select>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Отменить</a>
                                            <a href="javascript:;" @click="createConversation" class="btn btn-success">Создать</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
</template>

<script>
    import Swal from 'sweetalert2'
    import 'sweetalert2/src/sweetalert2.scss'

    export default {
        props:['authuser'],
        mounted() {
            this.getConversations();  
            console.log(this.authuser);         
        },
        data () {
            return {
                  conversations: {},
                  users: {},
                  options: [],
                  activeconversation: '',
                  selectedUser: []
            }
        },
        methods: {
          showName(user){
            if(user.profile != null){
              return user.profile.first_name +' '+ user.profile.second_name + '<' + user.email + '>';
            }else{
              return '<' + user.email + '>';
            }
          },
            createConversation(){
                 axios.post('/axios/chat/create-conversation', {user: this.selectedUser})
              .then(response => {
                if(Object.keys(response.data).length < 1){
                   this.$emit('isempty')
                }
                Swal.fire(
      'Выполнено!',
      'Диалог создан.',
      'success'
    )
                 this.getConversations();

                  $('#modal-create-chat').modal('hide');
                });
            },
            getConversations () {
                // Here we don't set isBusy prop, so busy state will be handled by table itself
                // this.isBusy = true

              axios.get('/axios/chat/get-conversations')
              .then(response => {
                if(Object.keys(response.data).length < 1){
                   this.$emit('isempty')
                }
                this.conversations = response.data

                });

               
            },
            getUsers: function onSearch(search, loading) {
              loading(true);
              this.search(loading, search, this);
            },
            search: _.debounce(function (loading, search, vm) {
              fetch("/axios/chat/get-users?q=" +
              escape(search)).
              then(function (res) {

                res.json().then(function (json) { 
                    return vm.options = json;});
                loading(false);
              });
            }, 350)
        }
    }
</script>
<style>

</style>