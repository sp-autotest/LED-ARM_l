@extends('layouts.default')

@section('htmlheader_title')
Профиль пользователя
@endsection


@section('content')
<div class="container spark-screen">
 <div class="row">
 <div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
 <div class="panel-heading"><strong>Профиль пользователя:</strong><a href="mailto:{{$user->email}}">{{$user->email}}</a> <br> <strong>Последний визит: </strong><i>{{$user->last_login_at}}</i> с <strong>IP адреса</strong>:<i>{{$user->last_login_ip}}</i> </div>
<div class="panel-body">	
  <form enctype="multipart/form-data" action="{{ url('/updateadminprofile') }}" method="POST">
  <label>Обновить профиль</label>
 @if (isset($profile->avatar))
  <input type="file" name="avatar">
  <img src="/storage/app/public/avatars/{{ $profile->avatar }}" style="width:150px; height:150px; float:left;"  />
 @else
  <input type="file" name="avatar">
  <img src="/public/img/avatar.png" style="width:150px; height:150px; float:left;" />
@endif
  <input id="uid" type="hidden" class="form-control" name="uid" value="{{ Auth::user()->id }}">
  {{ csrf_field() }}
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<label for="first_name" class="col-md-4 col-form-label text-md-right">Имя</label>
<div class="col-md-6"> 
 @if ($profile->first_name)
  <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
 value="{{ $profile->first_name }}" name="first_name" required>
 @else
  <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
 name="first_name" required>
 @endif
 @if ($errors->has('first_name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('first_name') }}</strong>
</span>
@endif
 </div>
<label for="middle_name" class="col-md-4 col-form-label text-md-right">Отчество</label>
<div class="col-md-6">
 @if ($profile->middle_name)
 <input id="middle_name" type="text" class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}"
 value="{{ $profile->middle_name}}" name="middle_name" required>
 @else
  <input id="middle_name" type="text" class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}"
 name="middle_name" required>
 @endif

 @if ($errors->has('middle_name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('middle_name') }}</strong>
</span>
@endif
 </div>


 <label for="second_name" class="col-md-4 col-form-label text-md-right">Фамилия</label>
<div class="col-md-6">
@if ($profile->second_name)
<input id="seconf_name" type="text" class="form-control{{ $errors->has('second_name') ? ' is-invalid' : '' }}"
 value="{{ $profile->second_name}}" name="second_name" required>
 @else
  <input id="second_name" type="text" class="form-control{{ $errors->has('second_name') ? ' is-invalid' : '' }}"
 name="second_name" required>
 @endif
 @if ($errors->has('second_name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('second_name') }}</strong>
</span>
@endif
 </div>

<label for="email" class="col-md-3 col-form-label text-md-right">E-mail</label>
<div class="col-md-6">
 <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $user->email}}" name="email" required>
 @if ($errors->has('email'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('email') }}</strong>
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
</div>
</div>
@endsection

