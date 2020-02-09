@extends('layouts.default')

@section('htmlheader_title')
Поиск компаний
@endsection


@section('content')
  <div class="container spark-screen">
  <div class="row">
  <div class="col-md-10 col-md-offset-1">
  <div class="panel panel-default">
  <div class="panel-heading">Профиль админа<h3> {{Auth::user()->name}}</h3></div>
  <div class="panel-body">
  	<h3 class="section-title">Поиск компании:</h3>
 <div class="form-group">    
 <form class="typeahead" role="search" method="GET" action= "{{ url('/search_company') }}">
<div class="form-group">
@if ($errors->has('query'))
<span class="help-block">
<strong>{{ $errors->first('query') }}</strong>
</span>
@endif
<input type="search" name="query" id="query" placeholder="Поиск" type="search">
</div>
<div class="form-group">
<input id="btn-submit" class="btn btn-send-message btn-md" value="Поиск" type="submit">
<span class="glyphicon glyphicon-search"></span>
 </button>
 </form>
</div>

@if (count($company_search) > 0) 
 <h3>Результаты поиска: <i>{{$query}} </i></h3>
 <h3>Обнаружено: {{$total}} совпадений</h3>    
<div class="row text-center">             
@else
 <h3>Результаты поиска: <i>{{$query}} </i></h3>
 <h3>Обнаружено: {{$total}} совпадений</h3> 
@endif
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Название компании</th>
        <th>Телефон</th>
        <th>Электронная почта</th>
         <th>Менеджер</th>
        <th>Валюта компании</th>
      </tr>
    </thead>
    <tbody>
      <tr>

 @foreach($company_search as $company)
     <td>{{$company->company_name}}</td>
     <td>{{$company->phone}}</td>
     <td>{{$company->finance_mail}}</td>
     <td>{{$company->first_name}}{{$company->third_name}}</td>
     <td>{{$company->currency_company}}</td>
      </tr>
      <tr>
 
 @endforeach
</tbody>
</table>
</div>
{!! $company_search->links() !!}  
@endsection

