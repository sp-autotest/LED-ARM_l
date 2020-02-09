<template>
     <div class="col-lg-3" id="contact-list">
                    <ul>
                        <li v-for="user in users">
                            <a href="javascript:;" @click="$emit('selectedconversation', user.id)">
                                <div class="contact-avatar">
                                    <img src="/img/admin.jpg" alt="" class="img-circle">
                                </div>
                                <span>{{user.name}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
</template>

<script>
   
    export default {
        mounted() {
            this.getUsers();
           
        },
        data () {
            return {
                  users: {},
            }
        },
        methods: {
            getUsers () {
                // Here we don't set isBusy prop, so busy state will be handled by table itself
                // this.isBusy = true

              axios.get('/axios/chat/get-conversations')
              .then(response => {
                if(Object.keys(response.data).length < 1){
                   this.$emit('isempty')
                }
                this.users = response.data

                });

               
            },
        }
    }
</script>
