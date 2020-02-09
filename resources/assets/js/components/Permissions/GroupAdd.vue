<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card card-default">
                    <div class="card-header">Добавить группу</div>

                    <div class="card-body">
                      <b-form @submit="onSubmit" @reset="onReset" >
                            <b-form-group id="formNameGroup" label="Название группы" label-for="formName">
                                <b-form-input
                                  id="formName"
                                  type="text"
                                  v-model="form.name"
                                  required
                                  placeholder="Enter name" />
                            </b-form-group>
                            <b-button type="submit" variant="primary">Добавить</b-button>
                            <b-button type="reset" variant="danger">Сбросить</b-button>
                      </b-form><br/>
                        <b-list-group>

                            <b-list-group-item :key="group.id" v-bind:variant="group.id == activegroup?'success':''" v-for="group in groups" style="cursor:pointer;" @click="selectGroup(group.id)" :id="'group-'+ group.id">{{group.name}}  <a href="javascript:;" @click="removeGroup(group.id)" class="float-right text-red
" ><i class="far fa-lg fa-fw fa-trash-alt"></i></a></b-list-group-item>

                        </b-list-group>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-default">
                    <div class="card-header">Список прав (перед началом выберите группу слева)</div>

                    <div class="card-body">
                       <b-table striped hover :items="permissions" :fields="permfields" >
                       <template slot="buttons" slot-scope="row">
                              <div class="switcher" v-bind:class="{disabled: checkactivegroup}">
                              <input type="checkbox" :name="row.item.name" :value="row.item.name" v-model="activeperms" @change="updatePermissions" :id="'switcher_checkbox_' + row.item.id" v-bind:checked="inArrayCheck(row.item.name)" v-bind:disabled="checkactivegroup == false" value="1">
                              <label :for="'switcher_checkbox_' + row.item.id"></label>
                            </div>

                            </template>
                        </b-table>
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
         data() {
      return {
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        form: {
          name: '',
        },
        groups: {},
        permissions: [],
        permfields: ['name', 'buttons'],
        checkactivegroup: false,
        activegroup: '',
        activeperms: []
      }
    },
        mounted() {
          this.getGroups();
          this.getAllPermissions();
          console.log(this.groups);
        },
      methods: {
      onSubmit(evt) {
        evt.preventDefault()

        axios.post('/admin/permissions/group-add', this.form)
              .then(response => {
                   this.getGroups();
                });
      //  alert(JSON.stringify(this.form))
      },
      onReset(evt) {
        evt.preventDefault()
        /* Reset our form values */
        this.form.name = ''

      },
      updatePermissions(data){
        if(this.activegroup == ''){
            console.log('GROUP IS UNDEFINED');
            return false;
        }
       
        console.log(this.activeperms);
        axios.post('/admin/permissions/update', {
                group: this.activegroup,
                permissions: this.activeperms
         })
              .then(response => {
                   this.selectGroup(this.activegroup);
                });
      },
      inArrayCheck(data) {
         if(this.activegroup == ''){
            console.log('GROUP IS UNDEFINED');
            return false;
        }
        if(this.activeperms.indexOf(data) != -1)
            {return true;}
        return false;
 
      },
      getGroups(){
         axios.get('/admin/permissions/groups-get')
              .then(response => {
                    this.groups = response.data;
                });
      },

      removeGroup(data){
        Swal.fire({
  title: 'Вы уверены?',
  text: 'Это действие невозможно обратить!',
  type: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Удалить!',
  cancelButtonText: 'Отменить'
}).then((result) => {
  if (result.value) {
    axios.post('/admin/permissions/group-delete', {
                _token: this.csrf,
                id: data
         })
              .then(response => {
                   this.getGroups();
                   console.log(response);
                   /*Swal.fire(
      'Выполнено!',
      'Группа удалена.',
      'success'
    )*/
                });
    
  // For more information about handling dismissals please visit
  // https://sweetalert2.github.io/#handling-dismissals
  } else if (result.dismiss === Swal.DismissReason.cancel) {
    Swal.fire(
      'Отменено!',
      'Вы отменили удаление группы :)',
      'error'
    )
  }
})
         console.log('REMOVED GROUP #' + data);
      },

      selectGroup(data){
        this.checkactivegroup = true;
        this.activegroup = data;
        var thi = this;
         axios.get('/admin/permissions/permissions-get', {
            params:{id:this.activegroup}
        })
              .then(response => {
                thi.activeperms = response.data;
                   
                });
        
      },
      getAllPermissions(){
          axios.get('/admin/permissions/permissions-get-all')
              .then(response => {
                    this.permissions = response.data;
                });
      }
    }
    }
</script>
