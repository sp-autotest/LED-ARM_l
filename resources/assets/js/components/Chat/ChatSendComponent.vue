<template>
    <div class="row">
        <div class="col-lg-12">
            <div id="input-block ">
                <form>
                    <div class="row">
                    <div class="col-lg-10">
                    <div class="form-group">
                        <label>Сообщение:</label>
                        <textarea class="form-control" rows="3" v-model="textMessage" @keyup.enter="sendMessage"></textarea>
                        <!--<input type="submit" class="form-control btn-primary" id="message-form-submit" value="">-->
                    </div>
                </div><div class="col-lg-2" style="position: relative;">
                    <b-button variant="success" @click="sendMessage" style="padding: 10px 20px; margin-top: 35px; position: absolute;" >ОТПРАВИТЬ</i></b-button></div></div>
                </form>
            </div>
        </div>
     </div>
</template>

<script>
    export default {
    	props:['conversation', 'sender'],
        data () {
		    return {
			      textMessage: '',
			      
			}
		},
        methods: {
            sendMessage () {
                // Here we don't set isBusy prop, so busy state will be handled by table itself
                // this.isBusy = true
              axios.post('/axios/chat/send-message', {text: this.textMessage, conversation_id: this.conversation, sender:this.sender})
              .then(response => {
                if(Object.keys(response.data).length < 1){
                   this.$emit('isempty')
                }
                this.users = response.data

                });
                this.$emit('newmessage', {text: this.textMessage, sender:this.sender});
                this.textMessage = '';
            },
        }
    }
</script>
