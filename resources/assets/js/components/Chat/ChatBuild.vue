<template>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-inverse" style="max-height:650px;">
              <div class="panel-heading">
                  <h3 class="box-title" style="color:#fff;">Чат</h3>
              </div>
              <!-- /.box-header -->
              <div class="panel-body">
                <div class="row">
                  <chat-user-component @selectedconversation="selectConversation" :authuser="authuser" @isempty="isEmpty"></chat-user-component>
                  <chat-component :messages="messages"></chat-component>
                </div>
                  <chat-send-component :sender="sender" :conversation="conversation" @newmessage="pushMessage"></chat-send-component>
              </div>
              <!-- /.box-body -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getMessages()
        },
        props:['sender', 'authuser'],
        data () {
            return {
                  conversation: undefined,
                  echoob: {},
                  messages: {},
                  empty_conversation: [
                    {to: 'inside-msg', sender:'Helper', text:'Чат пока пустой, отправьте первое сообщение!'}
                    ],
                  please_select_conversation: [
                    {to: 'inside-msg', sender:'Helper', text:'Выберите диалог!'},
                  ]
            }
        },
        methods: {
            selectConversation(data){
                this.echoob = {};
                this.conversation = data;
                console.log(data);
                this.getMessages();
                this.echoob = window.Echo.private('conversation.' + data)
                       .listen('Message', ({data, sender}) => {
                        console.log(data);
                        this.messages.push({text:data.text, to: 'inside-msg', sender:sender, time:'now'})
                       });
            },
            getMessages () {
                // Here we don't set isBusy prop, so busy state will be handled by table itself
                // this.isBusy = true
                if(this.conversation != undefined){
               axios.get('/axios/chat/get-messages?id='+this.conversation)
              .then(response => {
                if(Object.keys(response.data).length < 1){
                    this.$emit('isempty')
                    this.messages = {};
                    this.messages = this.empty_conversation;
                }else{
                    this.messages = response.data;
                }
                
                });
             
          }else{
             this.messages = this.please_select_conversation;
          }
                
               
            },
            isEmpty(){
                console.log('You have not Conversations');
            },
            pushMessage(data){
                this.messages.push({text:data.text, to: 'outside-msg', sender:data.sender, time:'now'})
            }
        }
    }
</script>
