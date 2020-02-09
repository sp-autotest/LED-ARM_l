<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
    </head>

    <style>

  body { font-family: DejaVu Sans, sans-serif; }
        td {
            border-bottom: 1px solid #ddd;
            margin: 2px;
        }
    </style>
    <body>
<div>

<style>
table.EticketTable {
  width: 100%;
  background-color: #ffffff;
  border-collapse: collapse;
  border-width: 1px;
  border-color: #075c0c;
  border-style: solid;
  color: #000000;
}

table.EticketTable td, table.EticketTable th {
  border-width: 1px;
  border-color: #075c0c;
  border-style: solid;
  padding: 1px;
}

table.EticketTable thead {
  background-color: #f5f5f5;
}
</style>

<table class="EticketTable">
<thead>
<tr>
<th><img src="{{ base_path() }}/public/storage/companies/images/{{$company['logo']}}" alt="ITM Systems" style="max-width: 600px; max-height: 50px;" /></th>
<th>Электронный билет Маршрутная квитанция</th>
</tr>
</thead>
<tbody>
<tr>
<td>Коды бронирования</td>
<td>Дата выписки</td>
</tr>
<?php $service = $services[0];?>
<tr>
<td>{{ $service['pnr'] }}</td>
<td>{{ $writeout_date }}</td>

</tr>

</tbody>
</table>


<h4>Пассажиры</h4>
<table class="EticketTable">
<thead>
<tr>
<td>ФИО</td>
<td>Билет</td>
<td>Документ</td>
<td>Тип пассажира</td>
</tr>
</thead>
<tbody>
<?php
$service = $services[0];
?>
     <tr>
<td>{{$service['passenger']['name'] }} {{$service['passenger']['surname'] }}</td>
<td>{{ $service['ticket']['ticket_number'] }}</td>
<td>{{ ($service['passenger']['type_documents'] == 1)?'Паспорт':'Другой документ' }}  №{{$service['passenger']['passport_number']}}
<td>
  @if($service['passenger']['type_passengers'] == 3)
    Младенец
  @elseif($service['passenger']['type_passengers'] == 2)
    Ребёнок
  @elseif($service['passenger']['type_passengers'] == 1)
    Взрослый
  @endif</td>
</tr>
<?php  ?>

</tbody>
</table>

<h4>Перелет</h4>

<table class="EticketTable">
  <thead>
    <tr>
      <th>Рейс</th>
      <th>Откуда</th>
      <th>Куда</th>
      <th>Время</th>
      <th>Класс</th>
      <th>Статус</th>
    </tr>
  </thead>
  <tbody>
     @foreach($services as $key=>$service)
        @foreach($service['flight']['flightplaces']['schedule'] as $f=>$fli)
        <tr>
          <td>{{ $fli['flights']}}</td>
          <td>{{ $fli['departure']['code_iata']}}  {{ $fli['departure']['name_eng']}} <{{$fli['departure']['city']['name_eng']}}> </td>
          <td>{{ $fli['arrival']['code_iata']}}  {{ $fli['arrival']['name_eng']}} <{{$fli['arrival']['city']['name_eng']}}> </td>
         
          <td><?php echo date('Y-m-d  h:i', strtotime($service['flight']['date_departure_at'].'T'.$fli['time_departure_at'])); ?> 
          </td>
          <td>{{ $service['fare']['name_eng'] }}</td>
          <td>Выписан</td>
        </tr>
        @endforeach
      @endforeach
     
        
  </tbody>
</table>


<h4>Стоимость</h4>

<table class="EticketTable">
  <thead>
    <tr>
      <th>Тариф</th>
      <th>Таксы</th>
      <th>Итого за билет</th>
    </tr>
  </thead>
  <tbody>

  <?php $service = $services[0];?>
    <tr>
      <td>
        {{$service['ticket']['rate_fare']}}
      </td>
      <td>
       
         {{ floatval($service['ticket']['types_fees_fare']) + floatval($service['ticket']['tax_fare']) }}
      </td>
      <td>{{$service['ticket']['summ_ticket']}}</td>
    </tr>

  
  </tbody>
</table>
<br/>
@foreach($company['ads'] as $ad)

<div style="text-align: center; ">
  <div style="display: inline-block;">
     <img src="{{ base_path() }}/public/storage/advertising/electronic_tickets_pictures/{{$ad['name']}}" style="max-width: 730px; max-height: 100px">
  </div>
</div>
@endforeach


</body>
</html> 
