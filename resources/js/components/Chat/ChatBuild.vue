<template>
      <div class="row">
        <div class="box" style="max-height:650px;">
            <div class="box-header">
                <h3 class="box-title">Чат</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <chat-user-component @selectedconversation="selectConversation" @isempty="isEmpty"></chat-user-component>
                <chat-component :messages="messages"></chat-component>
                <chat-send-component :sender="sender" :conversation="conversation" @newmessage="pushMessage"></chat-send-component>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getMessages()
        },
        props:['sender'],
        data () {
            return {
                  conversation: '',
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
                    this.messages =  this.empty_conversation;
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
