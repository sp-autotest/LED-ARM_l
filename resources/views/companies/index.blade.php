@extends('layouts.default')

@section('htmlheader_title')
Реестр компаний
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
</div>
</form>
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

 @foreach($companies as $company)
     <td>{{$company->company_name}}</td>
     <td>{{$company->phone}}</td>
     <td>{{$company->finance_mail}}</td>
     <td>{{$company->first_name }}</td>
     <td>{{$company->currency_company}}</td>
      </tr>
      <tr>
<td><a href="{{ URL::to('company-edit/'.$company->id) }}" span class="glyphicon glyphicon-wrench" title="Редактировать компанию">Редактировать компанию</span>
</a></td>  
<td><a href="{{ URL::to('company-add') }}" span class="glyphicon glyphicon-wrench" title="Добавить компанию">Добавить компанию</span></a>
</td>  
 @endforeach
</tbody>
</table>
</div>
  </div>
  </div>
  </div>
  </div>
  </div>
{!! $companies->links() !!}
@endsection

