<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Настройки рекламы маршрутной квитанции</div>

                    <div class="card-body">
                        <b-list-group>
                            <b-list-group-item>
                                <div class="row"><div class="col-lg-4">
                                <img v-if="checkPics(pics,'top')" :src="pics.top.path" style="max-height: 50px"></div><div class="col-lg-8">
                                <route-receipt-image-upload image_position="top"></route-receipt-image-upload>
                            </div></div></b-list-group-item>
                            <b-list-group-item> 
                                <div class="row"><div class="col-lg-4">

                                 <img v-if="checkPics(pics,'right')" :src="pics.right.path" style="max-height: 50px"></div><div class="col-lg-8">
                                <route-receipt-image-upload image_position="right"></route-receipt-image-upload></div></div>
                            </b-list-group-item>
                          <b-list-group-item>
                            <div class="row"><div class="col-lg-4">
                                <img v-if="checkPics(pics,'bottom')" :src="pics.bottom.path" style="max-height: 50px"></div><div class="col-lg-8">
                                <route-receipt-image-upload image_position="bottom"></route-receipt-image-upload>
                                </div></div>
                          </b-list-group-item>
                          <b-list-group-item>
                            <div class="row"><div class="col-lg-4">
                            <img v-if="checkPics(pics,'left')" :src="pics.left.path" style="max-height: 50px"></div><div class="col-lg-8">
                            <route-receipt-image-upload image_position="left"></route-receipt-image-upload>
                        </div></div>
                          </b-list-group-item>
                         
                        </b-list-group>
                        
                       
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:['pictures'],
        data(){
          return {
            pics: JSON.parse(this.pictures)
          }
        },
        methods:{
            checkPics(data, key){
                console.log(data);
                if(key in data){return true;}
                return false;
            }
        },
        mounted() {
            console.log(this.pics)
        }
    }
</script>
