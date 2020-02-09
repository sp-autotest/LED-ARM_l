<template>
  <div class="container">
    <div class="large-12 medium-12 small-12 cell">
      <label>File {{this.image_position}}
        <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
       </label>
      <b-button variant="success" v-on:click="submitFile()">Submit</b-button>
    </div>
  </div>
</template>

<script>
   import Swal from 'sweetalert2'
    import 'sweetalert2/src/sweetalert2.scss'


  export default {
    props:['image_position'],
    /*
      Defines the data used by the component
    */
    data(){
      return {
        file: ''
      }
    },

    methods: {
      /*
        Submits the file to the server
      */
      submitFile(){
        /*
                Initialize the form data
            */
            let formData = new FormData();

            /*
                Add the form data we need to submit
            */
            formData.append('file', this.file);
            formData.append('image_position', this.image_position);

        /*
          Make the request to the POST /single-file URL
        */
            axios.post( '/admin/settings/advertising/save',
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            ).then(function(data){
                if(data.statusText == 'Created'){
                  Swal.fire(
      'Выполнено!',
      'Изображение изменено. Перезагрузите страницу',
      'success'
    )
                 this.$emit('changed', {data: data});
                }
        })
        .catch(function(){
          console.log('FAILURE!!');
        });
      },

      /*
        Handles a change on the file upload
      */
      handleFileUpload(){
        this.file = this.$refs.file.files[0];
      }
    }
  }
</script>