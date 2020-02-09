@extends('layouts.default')

@section('title', 'Блок')



@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-inverse">

            <div class="panel-heading">
                <h3 class="panel-title">Размножить блок</h3>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">

    <div class="container spark-screen">
  <form class="form-horizontal" role="form"  id ="/postblockduplicated"  method="POST" action="{{ url('/postblockduplicated') }}">
<input id="place_id" type="hidden" class="form-control" name="place_id" value="{{ $place->id }}"> 
  <input id="uid" type="hidden" class="form-control" name="uid" value="{{ Auth::user()->id }}">
  {{ csrf_field() }}
      <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="feesplace_data" role="tabpanel" aria-labelledby="feesplace_data-tab">
              <div class="form-group">
                

  
 <div class="form-group">
   <h3>Размножить блок</h3>

<div class="form-group{{ $errors->has('schedule_id') ? ' has-error' : '' }}">
<label for="schedule_id" class="col-md-4 control-label">Расписание </label>
<div class="col-md-6">
<select name="schedule_id">
    <option selected disabled>Выбрать</option>
    @foreach($schedules as $schedule)
    <option value="{{ $schedule->id }}" selected>{{ $schedule->flights }}</option>
    @endforeach
</select>
@if ($errors->has('schedule_id'))
<span class="help-block">
<strong>{{ $errors->first('schedule_id') }}</strong>
</span>
 @endif
 </div>
</div>



<div class="form-group{{ $errors->has('fare_families_id') ? ' has-error' : '' }}">
<label for="fare_families_id" class="col-md-4 control-label">Класс обслуживания </label>
<div class="col-md-6">
<select name="fare_families_id">
    <option selected disabled>Выбрать</option>
    @foreach($farefamilies as $farefamily)
    <option value="{{ $farefamily->id }}" selected>{{ $farefamily->name_ru }}</option>
    @endforeach
</select>
@if ($errors->has('fare_families_id'))
<span class="help-block">
<strong>{{ $errors->first('fare_families_id') }}</strong>
</span>
 @endif
 </div>
</div>

 <div class="form-group{{ $errors->has('period_begin_at') ? ' has-error' : '' }}">
  <label for="period_begin_at" class="col-md-4 control-label">Период с</label>
  <div class="col-md-6">
  <input id="period_begin_at" type="text" class="form-control" name="period_begin_at"  value="{{ $place->period_begin_at }}">
 @if ($errors->has('period_begin_at'))
  <span class="help-block">
 <strong>{{ $errors->first('period_begin_at') }}</strong>
   </span>
   @endif
  </div>
   </div>

 <div class="form-group{{ $errors->has('period_end_at') ? ' has-error' : '' }}">
<label for="period_end_at" class="col-md-4 control-label">Период по</label>
<div class="col-md-6">
<input id="period_end_at" type="text" class="form-control" name="period_end_at"  value="{{ $place->period_end_at }}">
@if ($errors->has('period_end_at'))
<span class="help-block">
  <strong>{{ $errors->first('period_end_at') }}</strong>
  </span>
 @endif
 </div>
 </div>


   <label for="days_weeks" class="col-md-4 control-label">Дни недели </label>
<div class="col-md-6">
<input type="checkbox" name="monday" value="1">Понедельник
<br>
   <input type="checkbox" name="tuesday" value="1">Вторник<br>
   <input type="checkbox" name="wednesday" value="1">Среда<br> 
   <input type="checkbox" name="thursday" value="1">Четверг<br> 
   <input type="checkbox" name="friday" value="1">Пятница<br>
    <input type="checkbox" name="saturday" value="1">Суббота<br> 
   <input type="checkbox" name="sunday" value="1">Воскресенье<br>

</div>
  </div>




   <div class="form-group{{ $errors->has('count_places') ? ' has-error' : '' }}">
   <label for="count_places" class="col-md-4 control-label">Количество мест</label>
  <div class="col-md-6">
   <input id="count_places" type="text" class="form-control" name="count_places" value="{{ $place->count_place }}">
   @if ($errors->has('count_places'))
  <span class="help-block">
    <strong>{{ $errors->first('count_places') }}</strong>
    </span>
   @endif
  </div>
  </div>




     <div class="form-group{{ $errors->has('ow') ? ' has-error' : '' }}">
   <label for="ow" class="col-md-4 control-label"> Стоимость взрослый OW</label>
  <div class="col-md-6">
   <input id="ow" type="text" class="form-control" name="ow" value="{{ $place->ow }}">
   @if ($errors->has('ow'))
  <span class="help-block">
    <strong>{{ $errors->first('ow') }}</strong>
    </span>
   @endif
  </div>
  </div>


  <div class="form-group{{ $errors->has('infant_ow') ? ' has-error' : '' }}">
   <label for="infant_ow" class="col-md-4 control-label"> Стоимость инфант OW</label>
  <div class="col-md-6">
   <input id="infant_ow" type="text" class="form-control" name="infant_ow" value="{{ $place->infant_ow }}">
   @if ($errors->has('infant_ow'))
  <span class="help-block">
    <strong>{{ $errors->first('infant_ow') }}</strong>
    </span>
   @endif
  </div>
  </div>


 
     <div class="form-group{{ $errors->has('rt') ? ' has-error' : '' }}">
   <label for="rt" class="col-md-4 control-label"> Стоимость взрослый RT</label>
  <div class="col-md-6">
   <input id="rt" type="text" class="form-control" name="rt" value="{{ $place->rt }}">
   @if ($errors->has('rt'))
  <span class="help-block">
    <strong>{{ $errors->first('rt') }}</strong>
    </span>
   @endif
  </div>
  </div>


  <div class="form-group{{ $errors->has('infant_rt') ? ' has-error' : '' }}">
   <label for="infant_rt" class="col-md-4 control-label"> Стоимость инфант RT</label>
  <div class="col-md-6">
   <input id="infant_rt" type="text" class="form-control" name="infant_rt" value="{{ $place->infant_rt }}" >
   @if ($errors->has('infant_rt'))
  <span class="help-block">
    <strong>{{ $errors->first('infant_rt') }}</strong>
    </span>
   @endif
  </div>
  </div>






                      <div class="form-group{{ $errors->has('currency_id') ? ' has-error' : '' }}">
                      <label for="currency" class="col-md-4 control-label">Валюта</label>
                      <div class="col-md-6">
                          <select name="currency_id">
                              <option selected disabled>Выберите валюту</option>
                              @foreach($currencies as $currency)
                                  <option value="{{ $currency->id }}">{{ $currency->name_ru }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('currency_id'))
                              <span class="help-block">
<strong>{{ $errors->first('currency') }}</strong>
</span>
                          @endif
                      </div>
                  </div>




                  </div>

        </div>
                  </div>   

      <div class="form-group">
<div class="col-md-6 col-md-offset-4">
<button type="submit" class="btn btn-primary">
    Добавить
</button>
</div>
</div>
  </form>
    </div>

</div>
</div>
</div>
</div>
</div>
@endsection
