
<p>
Здравствуйте,

<br>
<hr>



<?php $cudate = \Carbon\Carbon::now();?>

В {{$order->created_at}} для {{$company['company_name']}} в заказе №{{$order->order_n}} Вами забронирована авиауслуга. Бронь необходимо выкупить до {{date('Y-m-d H:i', strtotime($cudate)+$order->time_limit)}}. Если бронь невыкуплена, авиакомпания вправе ее анулировать
<br>


Информация о бронировании:<br>
Маршрут:<br>
@foreach($flights as $flight)
    @foreach($flight['flightplaces']['schedule'] as $schedule)
        {{$schedule['departure']['city']['name_ru']}} - {{$schedule['arrival']['city']['name_ru']}}<br>
        Дата вылета: {{$flight['date_departure_at']}}<br>
        Авиакомпания:{{$schedule['airline']['aviacompany_name_ru']}}<br>
        Класс:{{$flight['flightplaces']['farefamily']['name_ru']}}<br>
    @endforeach

@endforeach





<br>

Пассажиры:
@foreach($passengers as $passenger)<br>
{{$passenger['name']}} {{$passenger['surname']}}
@endforeach
<br>
Стоимость {{$order['order_summary']}} {{$company['currency']['code_literal_iso_4217']}}



<br>

<br>
<hr>
<br>

Администратор


ЭТО ПИСЬМО СГЕНЕРИРОВАНО АВТОМАТИЧЕСКИ, ПРОСЬБА НЕ ОТВЕЧАТЬ