 
@extends('layouts.default')

@section('title', trans('adminlte_lang::message.companies'))



@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-inverse">

            <div class="panel-heading">
                <h3 class="panel-title">Информация о билете</h3>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">

    <div class="container spark-screen">
    <div class="row">
    <div class="col-lg-10 col-md-offset-1">
    
  </div>
  </div>
  <form class="form-horizontal" role="form"  id ="/postreadbooking" method="POST" action="{{ url('/postreadbooking') }}">
  {{ csrf_field() }}
      <div class="form-group">
<h3>Данные рейса</h3>



<div class="form-group{{ $errors->has('bookingReferenceID') ? ' has-error' : '' }}">
<label for="bookingReferenceID" class="col-md-4 control-label">Идентификатор заказа</label>
<div class="col-md-6">
<input id="bookingReferenceID" type="text" class="form-control" name="bookingReferenceID" value="0R4STA">
@if ($errors->has('bookingReferenceID'))
<span class="help-block">
<strong>{{ $errors->first('bookingReferenceID') }}</strong>
</span>
 @endif
 </div>
</div>


 
<div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
<label for="surname" class="col-md-4 control-label">Фамилия</label>
<div class="col-md-6">
<input id="surname" type="text" class="form-control" name="surname" value="TEST">
@if ($errors->has('surname'))
<span class="help-block">
<strong>{{ $errors->first('surname') }}</strong>
</span>
 @endif
 </div>
</div>





</div>
<div class="form-group">
<div class="col-md-6 col-md-offset-4">
<button type="submit" class="btn btn-primary">
 <i class="fa fa-btn fa-id-card"></i>&nbsp;&nbsp;Искать
</button>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
@endsection
