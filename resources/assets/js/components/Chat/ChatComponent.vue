<template>
    <div class="col-lg-9">
          <div data-scrollbar="true" data-height="400px">
        <div class="chat-block">
            <div v-for="message in messages" :class="message.to">
                <b>{{message.sender}}</b>
                <div class="contact-avatar">
                    <i class="fas fa-lg fa-fw m-r-10 fa-comment"></i>
                </div>
                {{message.text}}
                {{message.time}}
            </div>
           
        </div>
    </div>
    </div>
</template>

<script>
    export default {
      
        props:['messages'],
        

    }
</script>
