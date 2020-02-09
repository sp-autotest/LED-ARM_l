@extends('layouts.default')

@section('htmlheader_title')
Поиск рейса:результат
@endsection


@section('content')
  <div class="container spark-screen">
  <div class="row">
  <div class="panel panel-default">



<br>


</div>


</div>

</div>
   <div class="panel panel-default">
   	<h3>Результат поиска</h3>Найдено вариант
  <form class="form-horizontal" role="form"  id ="/getneworder" method="GET" action="{{ url('/getneworder') }}">
  {{ csrf_field() }}
  <input id="user_id" type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Вылет</th>
      <th scope="col">Прилет</th>
      <th scope="col">Пересадки</th>
      <th scope="col">Время в пути</th>
      <th scope="col">Время отправления</th>
      <th scope="col">Рейс</th>
    </tr>
  </thead>
  <tbody>
  <tr> 

  <td> 
  Вылет
  <codeContext>IATA</codeContext>
						<!-- Код аэропорта прибытия по IATA-->	
                            <locationCode>ALA</locationCode>
						<!-- Наименование города прибытия -->
<locationName>Almaty</locationName>
Дата отправления
<departureDateTime>2019-02-10T00:00:00+05:00
  </td> 

    <td> 

  Прилет 	
  <codeContext>IATA</codeContext>
							<!-- Код аэропорта прибытия по IATA-->
                            <locationCode>ASB</locationCode>
							<!-- Наименование города прибытия -->
<locationName>Ashgabad</locationName>
<!-- Дата вылета -->
 <departureDate>2019-02-10T00:00:00+05:00</departureDate>

  </td> 

    <td> 
Пересадки
<directFlightOnly>
  </td> 

    <td> 
Время в пути
<departureDateTime>2019-02-10T00:00:00+05:00
  </td> 

  <td> 
Дата отправления
Разница между 2 датами:

<departureDateTime>2019-02-10T00:00:00+05:00 -  <departureDate>2019-02-10T00:00:00+05:00</departureDate>


  </td> 


    <td> 
Рейс
 <flightNumber>715</flightNumber>
  </td> 

  </tr>

  <amount>
  Цена которая внизу
										
                                                            <currency>
                                                                <code>RUB</code>
                                                            </currency>
												
                                                            <value>26455.0</value>
</amount>
 </tbody>
</table>
<div class="panel panel-default">
<div class="form-group">

<div class="col-md-6 col-md-offset-4">
<button type="submit" class="btn btn-primary">
 <i class="fa fa-btn fa-id-card"></i>&nbsp;&nbsp;Заказать
</button>
</div>
 <a href="{{ URL::to('/moreinfo') }}">
 <span class="glyphicon glyphicon-wrench" title="Подробнее">Подробнее</span>
</a>
 <a href="{{ URL::to('/tarifs') }}">
 <span class="glyphicon glyphicon-wrench" title="Правила тарифов">Правила тарифов</span>
</a>
</div>
</div>
</form>
</div>
@endsection