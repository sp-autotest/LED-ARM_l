<template>
  <div class="panel panel-default">
    <h3>Результат поиска</h3>Найдено вариантов: 
  <b-list-group>
    <b-list-group-item v-for="(flight, index) in searchobj.result" @click="selected = index" :key="index" class="m-b-25 flightitem" style=" border: 2px solid #EEEEEE; box-sizing: border-box; border-radius: 4px;">
      <div class="row row  p-l-15 p-r-25 p-t-5  ">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-lg-12">
                <div class="row"><div class="col-lg-12"> 
                  <b><span class="pull-left">{{flight.departureAirport.name_ru}}</span>
                  <ios-airplane-icon  rootClass="colorthemegreen m-r-25 m-l-25 fa-2x "></ios-airplane-icon> <span class="pull-left">{{flight.arrivalAirport.name_ru}} </span> </b>  <span class="pull-left m-l-25">вылет {{makeDate(flight.departureDateTime.value)}}</span></div>
                </div>
            </div>
          </div>
          <div class="row">
            <table class="table">
              <thead class="">
                <tr>
                  <th scope="col">Вылет</th>
                  <th scope="col">Прилет</th>
                  <th scope="col">Пересадки</th>
                  <th scope="col">Время в пути</th>
                  <th scope="col">Рейс</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{makeTime(flight.departureDateTime.value)}}</td>
                  <td>{{makeTime(flight.arrivalDateTime.value)}}</td>
                  <td>Прямой</td>
                  <td>{{getDifferenceDate(flight.departureDateTime.value, flight.arrivalDateTime.value)}}</td>
                  <td>{{flight.flightNumber}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row p-t-15 p-b-15" v-if="index == selected" style="border-top: dashed 2px rgba(31, 32, 65, 0.25);">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-3" v-for="(bookingCard, bindex) in flight.bookingClasses" v-bind:class="[(bindex == bSelected)?'bselected':'']" @click="setBookingCard(bookingCard, bindex)">
                <div class="card p-10 bookingCard">
                  {{bookingCard.bookingClass.cabin.value}} {{bookingCard.bookingClass.resBookDesigCode.value}}<br/>
                  {{bookingCard.fareDisplayInfos.fareDisplayInfoList.pricingInfoList.totalFare.amount.value.value}} {{bookingCard.fareDisplayInfos.fareDisplayInfoList.pricingInfoList.totalFare.amount.currency.code.value}}
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row p-t-15 p-b-15" v-if="index == selected" style="border-top: dashed 2px rgba(31, 32, 65, 0.25);">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6">
              <a href="#">Подробнее {{index}}</a>
              <a href="#">Правила тарифов</a>
            </div>
            <div class="col-lg-6">
              
              <b-button variant="success" class="pull-right" @click="sendFlight(flight, bookingOption, searchobj.request)">Забронировать</b-button>
              <span class="pull-right m-r-25" style="font-family: Montserrat; font-style: normal; font-weight: bold; font-size: 18px; line-height: normal; text-transform: uppercase; color: #4DC56F;">От {{flight.bookingClasses[0].fareDisplayInfos.fareDisplayInfoList.pricingInfoList.totalFare.amount.value.value}} {{flight.bookingClasses[0].fareDisplayInfos.fareDisplayInfoList.pricingInfoList.totalFare.amount.currency.code.value}}</span>
            </div>
          </div>
        </div>
      </div>
    </b-list-group-item>
  </b-list-group>
<div class="modal modal-message fade" id="modal-message">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Бронирование</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                      <booking-create :managers="managers" :crane="query"></booking-create>
                    </div>
                    <div class="modal-footer">
                    </div>
                  </div>
                </div>
              </div>
  </div>
</template>

<script>
    export default {
        props:['searchobj', 'auth_user', 'managers'],
        update() {
            console.log('START');
            console.log(this.searchobj);
            console.log('END');
        },
        mounted(){
        },
        methods: {
          setBookingCard(data, index){
              this.bookingOption = data;
              this.bSelected = index;
          },
          makeDate(date){
            var d = new Date(date);
            var newdate = '';
            var weekday = this.week[d.getUTCDay()];
            return  d.getUTCDate() + ' ' +this.monthNames[d.getUTCMonth()]  + ', ' +                                                weekday ;
          },
          sendFlight(data, option, request){
            this.query = {data:data, request:request, option:option};
            console.log(this.query);
            $('#modal-message').modal('show');
            
          },
          makeTime(date){
            var d = new Date(date);
            return d.getUTCHours()+':'+d.getUTCMinutes();
          },
          getDifferenceDate(date1, date2){
            date2 = new Date(date2);
            date1 = new Date(date1);

            var msec = date2 - date1;
            var mins = Math.floor(msec / 60000);
            var hrs = Math.floor(mins / 60);
            var days = Math.floor(hrs / 24);
            var yrs = Math.floor(days / 365);
            mins = mins % 60;
            return hrs + ':' + mins;
          }
        },
        data() {
           return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            week: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
            monthNames: ["Января", "Февраля", "Марта", "Апреля", "Мая", "Июня",
  "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"],
            selected: -1,
            bookingOption:'',
            bSelected: '',
            query: '',
           }
        },
    }
</script>
<style>
  .colorthemegreen {
    fill: #4DC56F;
    float: left;
  }
  .flightitem {
    cursor: pointer;
    background: #FBFBFB;
  }
  .bookingCard:hover {
    background: rgba(255,200,200,0.2);
  } 
  .flightitem:hover {
     background: rgba(200,200,200,0.2);
  }
  .bselected .bookingCard{
    background: rgba(200,255,200,0.4);
  }
</style>