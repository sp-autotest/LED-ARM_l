<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
    </head>

    <style>

 	body { font-family: DejaVu Sans, sans-serif; }
        td {
            border-bottom: 1px solid #ddd;
            margin: 5px;
        }
    </style>
    <body>
        <div>




            <table cellspacing="0">
                <thead style="background-color: #eeeeee; border: none;">
                    <tr>

                        <th width="120px" height="35px" style="margin: 5px">Название компании</th>

                        <th width="220px">
Адрес:</th>
                        <th width="260px">ИНН

</th>
                        <th width="260px">
KPP</th>

                        <th width="118px">Счет #</th>

                        <th width="118px">Получатель</th>

                        <th width="118px">Банк получателя</th>

                        <th width="118px">БИК</th>
                        <th width="118px">Номер счета №</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
         
                      
            <td>{{ $cp->company_name }}</td>
            <td>{{ $cp->legal_company_name }}</br>
                {{ $cp->post_address }}</br>
                {{ $cp->city }}
            </td>
            <td>{{ $cp->inn}}</td>
            <td>{{ $cp->kpp }}</td>
            <td>{{ $cp->сhecking_account}}</td>
            
            <td>{{ $cp->bank_name }}</td>
            <td>{{ $cp->bik }}</td>
           <td>{{ $cp->correspondent_account }}</td>

                 
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html> 

<table border="1">
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td>Название компании {{ $cp->company_name }}{{ $cp->legal_company_name }}</td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td>Адрес:{{ $cp->post_address }}</br>
                {{ $cp->city }}</td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>

<tr><td>ИНН{{ $cp->inn}}</td></tr>
<tr><td></td></tr>
<tr><td>КПП{{ $cp->kpp }}</td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td>Сч. №{{ $cp->сhecking_account}}</td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td>Получатель</td></tr>
<td>{{ $cp->first_name }}</br>
              {{$cp->second_name}} </br>
              {{$cp->third_name}}</td>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td>Банк получателя{{ $cp->bank_name }}</td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td>БИК{{ $cp->bik }}</td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td>Сч. №{{ $cp->correspondent_account }}</td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td>Счет № {{ $cp->correspondent_account }} от {{$cp->created_at}}г.</td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td>Плательщик:{{$cp->commission_business}}
    {{$cp->commission_first}}
    {{$cp->commission_economy}}</td></tr>
</table>


Всего к оплате:

Всего наименований, на сумму. 

@php
digit_text($cp->commission_business + $cp->commission_first + $cp->commission_economy, 'ru', true);
@endphp




Сумма прописью





Руководитель предприятия _____________________________ 

Главный бухгалтер              _____________________________



