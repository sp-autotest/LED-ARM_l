<template>
    <div class="container" id="search-crane-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h3 class="panel-title">Поиск рейса</h3>
                    </div>
            <!-- /.panel-header -->
                    <div class="panel-body" >
                        <div class="radio radio-css radio-inline m-r-10"  @click="updateData('one-way')">
                            <input type="radio" @change="updateData('one-way')" value="one-way" id="one" v-model="tiketway">
                            <label for="one" class="checkmark"><div class="checkedadd"></div></label>
                            В одну сторону
                        </div>
                        <div class="radio radio-css radio-inline m-r-10" @click="updateData('round-trip')">Туда-обратно
                            <input type="radio" @change="updateData('round-trip')" value="round-trip" id="two" v-model="tiketway">
                            <label for="two" class="checkmark"><div class="checkedadd"></div></label>
                        </div>
                        <div class="radio radio-css radio-inline m-r-10" @click="updateData('multisegment')">Многосегментный
                            <input type="radio" @change="updateData('multisegment')" value="multisegment" id="three" v-model="tiketway">
                            <label for="three" class="checkmark"><div class="checkedadd"></div></label>
                        </div>
                        <div class="switcher checkbox-css checkbox-inline" style="    position: relative; top: 6px;">
                          <input type="checkbox" v-model="directflights" id="inlineCssCheckbox1"  />
                          <label for="inlineCssCheckbox1"></label>
                        </div>
                        Только прямые рейсы
                        <div v-for="(event, segment, skey) in segments">
                            <crane-segment :tiketway="tiketway" @changed="setSegment" :skey="segment"></crane-segment>
                        </div>
                        <div v-if="tiketway == 'multisegment'">
                        <a href="javascript:;" style="color:#00FF86;" @click="addSegment()" ><i class="fas  fa-fw m-r-10 m-t-15 fa-plus-circle"></i>Добавить сегмент</a>
                        </div>
                        <label class="m-t-25">Класс обслуживания</label>
                        <div class="row ">

                            <div class="radio radio-css radio-inline m-r-10" @click="classflight = 'econom'">
                                <input type="radio" id="economflight" value="econom" v-model="classflight">
                                <label for="economflight" class="checkmark"><div class="checkedadd"></div></label>
                                Эконом
                            </div>
                            <div class="radio radio-css radio-inline m-r-10" @click="classflight = 'comfort'">  Комфорт
                                <input type="radio" id="comfortflight" value="comfort" v-model="classflight">
                                <label for="comfortflight" class="checkmark"><div class="checkedadd"></div></label>
                            </div>
                            <div class="radio radio-css radio-inline m-r-10" @click="classflight = 'business'">Бизнес
                                <input type="radio" id="businessflight" value="business" v-model="classflight">
                                <label for="businessflight" class="checkmark"><div class="checkedadd"></div></label>
                            </div>
                            <div class="col-lg-1" v-if="tiketway == 'multisegment'" >
                            <label for="adultpeople">Взрослые</label>
                                <input type="number" id="adultpeople" min="1" v-model="adultpeople" class="form-control "  placeholder="">
                            </div>
                            <div class="col-lg-1" v-if="tiketway == 'multisegment'">
                                <label for="childrens">Дети</label><input id="childrens" type="number" min="1" class="form-control "  placeholder=""></div>
                            <div class="col-lg-1" v-if="tiketway == 'multisegment'">
                                <label for="baby">Младенцы</label><input id="baby" type="number" min="1" class="form-control "  placeholder=""></div>
                        </div>
                        <button class="btn btn-success m-t-25 searchbtn" id="search-flight" @click="searchFlight()">Поиск</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import 'bootstrap-datepicker'
    import 'ion-rangeslider'
    export default {
        mounted() {
            //
            $('.datepicker-autoClose').datepicker({
                todayHighlight: true,
                format: 'dd.mm.yyyy',
                startDate: '-0d',
                autoclose: true
            });
            this.addSegment();
        },
        data() {
           return {
            tiketway:'one-way',
            directflights:false,
            classflight:'',
            segments:[],
            countsegments:0,
            baby:'',
            childrens:'',
            adultpeople:'',
           }
       },
       
        methods: {
            updateData(data){
                this.tiketway = data;
                console.log('worked');
        if(this.tiketway != 'multisegment'){
            this.segments = [];
            this.countsegments = 1;
            this.addSegment();
        }
       },
            onReset(){},
            onSubmit(){},
            testData(data){
                console.log([this.adultpeople, data]);
            },
            setSegment(data){
           console.log(data);
                this.segments[data.skey] = data;
                       console.log(this.segments);
                
            },
            setCityFrom(){},
            setCityTo(){},
            searchFlight(){
                var query = {
                    tiketway:this.tiketway,
                    directflights:this.directflights,
                    classflight:this.classflight,
                    segments:this.segments,
                    countsegments:this.countsegments,
                    baby:this.baby,
                    childrens:this.childrens,
                    adultpeople:this.adultpeople,
                };
                console.log(query);
            },
            addSegment(){
                this.countsegments++;
                this.segments.push({id: this.countcontacts});

            },
        },
    }
</script>

<style>
#search-crane-container .radio {
  display: inline-block;
  position: relative;
  cursor: pointer;
  
}

#search-crane-container .radio input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}
.searchbtn {
    background: #5CDF81;
    border-radius: 4px;
    font-family: Montserrat;
    font-style: normal;
    font-weight: bold;
    font-size: 12px;
    line-height: normal;
    text-align: center;
    text-transform: uppercase;

    color: #FFFFFF;
}
.checkmark {
  position: absolute;
  top: 5px;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border-radius: 50%;
}
#search-crane-container .radio.radio-css.radio-inline {
    padding-left: 27px;
}
.radio:hover input ~ .checkmark {
  background-color: #ccc;
}
.radio.radio-css label {padding:0;}
#search-crane-container .radio.radio-css input:checked+label {padding-left: 0px; background: #00F581;}
#search-crane-container .radio.radio-css label:before {}

#search-crane-container .radio.radio-css input:checked+label:before {
background-color:#00F581;
}
.radio.radio-css label:before {
    content: '';
    position: absolute;
    left: 2px;
    top: 2px;
    width: 16px;
    height: 16px;
    border-radius: 16px;
    background: #dee2e6;
}
.radio input:checked ~ .checkmark div {
  position: absolute;
  background-color:#00F581;
  height:12px;
  width:12px;
  top:4px;
  left:4px;
  z-index:1;
  border-radius:50%;
}
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}
.radio input:checked ~ .checkmark:after {
  display: block;
}
.radio .checkmark:after {
    top: 1px;
    left: 1px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: white;
}
#search-crane-container .radio.radio-css input:checked+label:after {
        z-index: 1;
        background-color:#00F581;
        top:5px;
        left:5px;
        border-radius: 50%;
        width: 10px;
        height: 10px;
}
#search-crane-container input:checked ~ .checkmark .checkedadd {
  position: absolute;
  background-color:#fff;
  height:16px;
  width:16px;
  top:2px;
  left:2px;
  z-index:1;
  border-radius:50%;
}
#search-crane-container .switcher label:before {
    width: 37px;
    height: 20px;
}
#search-crane-container .switcher label:after {
    height: 15px;
    width: 15px;
}
#search-crane-container .switcher label {
    height: 20px;
}
#search-crane-container .switcher input:checked+label:before {
    background-color:#00F581;
    border-color:#00F581;
}
</style>