@extends('layouts.default')

@section('title', 'Расписание')



@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-inverse">

            <div class="panel-heading">
                <h3 class="panel-title">Редактировать расписание</h3>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">

    <div class="container spark-screen">


  <form class="form-horizontal" role="form"  id ="/postscheduledit"  method="POST" action="{{ url('/postscheduledit') }}">
   <input id="schedule_id" type="hidden" class="form-control" name="schedule_id" value="{{ $schedule->id }}">
  <input id="uid" type="hidden" class="form-control" name="uid" value="{{ Auth::user()->id }}">
  {{ csrf_field() }}


    
      <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="feesplace_data" role="tabpanel" aria-labelledby="feesplace_data-tab">
              <div class="form-group">
              

  
 <div class="form-group">
   <h3>Редактировать расписание</h3>


   <div class="form-group{{ $errors->has('flights') ? ' has-error' : '' }}">
   <label for="flights" class="col-md-4 control-label"> Номер рейса</label>
  <div class="col-md-6">
   <input id="flights" type="text" class="form-control" name="flights" value="{{ old('flights') }}" value="{{ $schedule->flights}}">
   @if ($errors->has('flights'))
  <span class="help-block">
    <strong>{{ $errors->first('flights') }}</strong>
    </span>
   @endif
  </div>
  </div>





    



  <div class="form-group{{ $errors->has('period_begin_at') ? ' has-error' : '' }}">
  <label for="period_begin_at" class="col-md-4 control-label">Период с</label>
  <div class="col-md-6">
  <input id="period_begin_at" type="text" class="form-control" name="period_begin_at" value="{{ $schedule->period_begin_at}}" value="{{ old('period_begin_at') }}">
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
<input id="period_end_at" type="text" class="form-control" name="period_end_at" value="{{ $schedule->period_end_at}}" value="{{ old('period_end_at') }}">
@if ($errors->has('period_end_at'))
<span class="help-block">
  <strong>{{ $errors->first('period_end_at') }}</strong>
  </span>
 @endif
 </div>
 </div>



     <div class="form-group{{ $errors->has('time_ arrival_transfer_at') ? ' has-error' : '' }}">
   <label for="time_arrival_transfer_at" class="col-md-4 control-label"> Время вылета</label>
  <div class="col-md-6">
   <input id="time_ arrival_transfer_at" type="text" class="form-control" name="time_arrival_transfer_at" value="{{ old('time_ arrival_transfer_at') }}">
   @if ($errors->has('flights'))
  <span class="help-block">
    <strong>{{ $errors->first('flights') }}</strong>
    </span>
   @endif
  </div>
  </div>
               

   <div class="form-group{{ $errors->has('time_departure_at') ? ' has-error' : '' }}">
   <label for="time_departure_at" class="col-md-4 control-label"> Время прилета</label>
  <div class="col-md-6">
   <input id="time_departure_at" type="text" class="form-control" name="time_departure_at" value="{{ $schedule->time_departure_at}}"  value="{{ old('time_departure_at') }}">
   @if ($errors->has('time_departure_at'))
  <span class="help-block">
    <strong>{{ $errors->first('time_departure_at') }}</strong>
    </span>
   @endif
  </div>
  </div>



   <div class="form-group{{ $errors->has('time_arrival_at') ? ' has-error' : '' }}">
   <label for="time_arrival_at" class="col-md-4 control-label"> Время в пути</label>
  <div class="col-md-6">
   <input id="time_arrival_at" type="text" class="form-control" name="time_arrival_at" value="{{ $schedule->time_arrival_at}}"  value="{{ old('time_arrival_at') }}">
   @if ($errors->has('time_arrival_at'))
  <span class="help-block">
    <strong>{{ $errors->first('time_arrival_at') }}</strong>
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


 <div class="form-group{{ $errors->has('bc_types_id') ? ' has-error' : '' }}">
                      <label for="bc_types_id" class="col-md-4 control-label">Тип BC</label>
                      <div class="col-md-6">
                          <select name="bc_types_id">
                              <option selected disabled>Тип BC</option>
                              @foreach($bc_types as $bc_type)
                                  <option value="{{ $bc_type->id }}" selected>{{ $bc_type->name_ru }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('bc_types_id'))
                              <span class="help-block">
                <strong>{{ $errors->first('bc_types_id') }}</strong>
                   </span>
                          @endif
                      </div>
                  </div>



                      <div class="form-group{{ $errors->has('airlines_id') ? ' has-error' : '' }}">
                      <label for="airlines_id" class="col-md-4 control-label">Авиакомпания</label>
                      <div class="col-md-6">
                          <select name="airlines_id">
                              <option selected disabled>Выберите авиакомпанию</option>
                              @foreach($airlines as  $airline)
                                  <option  value="{{ $airline->id }}" selected>{{ $airline->code_tkp }}   {{ $airline->short_aviacompany_name_ru }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('airlines_id'))
                              <span class="help-block">
                <strong>{{ $errors->first('airlines_id') }}</strong>
                   </span>
                          @endif
                      </div>
                  </div>

          <div class="form-group{{ $errors->has('next_day') ? ' has-error' : '' }}">
                      <label for="next_day" class="col-md-4 control-label">Следующий день</label>
                      <div class="col-md-6">
                          <select name="next_day">
                              <option selected disabled>Выберите</option>
                             <option value="0" selected>Нет</option>
                            <option value="1">Да</option>

                          </select>
                          @if ($errors->has('next_day'))
                              <span class="help-block">
                <strong>{{ $errors->first('next_day') }}</strong>
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
    Сохранить
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
