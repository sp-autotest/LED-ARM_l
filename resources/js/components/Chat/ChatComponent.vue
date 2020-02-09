<template>
    <div class="col-lg-9">
                    <div class="chat-block">
                        <div v-for="message in messages" :class="message.to">
                            <b>{{message.sender}}</b>
                            <div class="contact-avatar">
                               
                            </div>
                            {{message.text}}
                            {{message.time}}
                        </div>
                       
                    </div>
                </div>
</template>

<script>
    export default {
      
        props:['messages'],
        

    }
</script>
