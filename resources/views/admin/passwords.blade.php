@extends('adminlte::layouts.app')

@section('htmlheader_title')
Обновить пароль
@endsection


@section('main-content')
  <div class="container spark-screen">
  <div class="row">
  <div class="col-md-10 col-md-offset-1">
  <div class="panel panel-default">
  <div class="panel-heading">Профиль админа<h3> {{Auth::user()->name}}</h3></div>
  <div class="panel-body">
  <form class="form-horizontal"  role="form" method="POST" action="{{ url('/updatepassword') }}">
  <input id="uid" type="hidden" class="form-control" name="uid" value="{{ Auth::user()->id }}">
  {{ csrf_field() }}

<label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>
<div class="col-md-6">
 <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
 @if ($errors->has('password'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('password') }}</strong>
</span>
@endif
 </div>

<label for="confirm_password" class="col-md-4 col-form-label text-md-right">Подтвердите Пароль</label>
<div class="col-md-6">
 <input id="confirm_password" type="password" class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" name="confirm_password" required>
 @if ($errors->has('confirm_password'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('confirm_password') }}</strong>
</span>
@endif
 </div>


<div class="form-group">
<div class="col-md-6 col-md-offset-4">
<button type="submit" class="btn btn-primary">
 <i class="fa fa-btn fa-user"></i> Обновить
</button>
</div>
</div>
                    
</form>
</div>
</div>
</div>
 



  
@endsection











