@extends('layouts.default')

@section('title', 'Сбор')



@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-inverse">

            <div class="panel-heading">
                <h3 class="panel-title">Добавить сбор</h3>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">

    <div class="container spark-screen">

  <form class="form-horizontal" role="form"  id ="/postfeesplaceadd"  method="POST" action="{{ url('/postfeesplaceadd') }}">
  <input id="uid" type="hidden" class="form-control" name="uid" value="{{ Auth::user()->id }}">
  {{ csrf_field() }}
     <nav class="nav desktop-tabs">
          <a class="nav-link active" href="#feesplace_data" id="feesplace_data-tab" data-toggle="tab" role="tab" aria-controls="feesplace_data" aria-selected="true">Параметры заказа</a>
          <a class="nav-link" href="#feesplace_order_data" id="finance_order_data-tab" data-toggle="tab" role="tab" aria-controls="feesplace_order_data" aria-selected="false">Величины сбора</a>
          <!--<a class="nav-link disabled" href="#">Disabled</a>-->
      </nav>


    
      <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="feesplace_data" role="tabpanel" aria-labelledby="feesplace_data-tab">
              <div class="form-group">
                  <h3>Параметры заказа</h3>

              <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
<label for="company_id" class="col-md-4 control-label">Название компании</label>
<div class="col-md-6">
<select  name="company_id">
<option selected disabled>Выберите компанию</option>
@foreach($companies as $company)
      <option value="{{ $company->id }}" selected>{{ $company->company_name}}</option>
     @endforeach
    </select>  
@if ($errors->has('company_id'))
<span class="help-block">
<strong>{{ $errors->first('company_id') }}</strong>
</span>
 @endif
 </div>
</div>



                  <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                      <label for="date_start" class="col-md-4 control-label">Дата начала действия(периода продаж)</label>
                      <div class="col-md-6">
                          <input id="date_start" type="text" class="form-control" name="date_start" value ="2019-03-30">
                          @if ($errors->has('date_start'))
                              <span class="help-block">
                  <strong>{{ $errors->first('date_start') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>



                
                  <div class="form-group{{ $errors->has('date_stop') ? ' has-error' : '' }}">
                      <label for="date_stop" class="col-md-4 control-label">Дата окончания действия</label>
                      <div class="col-md-6">
                          <input id="date_stop" type="text" class="form-control" name="date_stop" value ="2019-03-31">
                          @if ($errors->has('date_stop'))
                              <span class="help-block">
                  <strong>{{ $errors->first('date_stop') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>





  
                  <div class="form-group{{ $errors->has('period_begin_at') ? ' has-error' : '' }}">
                      <label for="period_begin_at" class="col-md-4 control-label">Дата начала вылета</label>
                      <div class="col-md-6">
                          <input id="period_begin_at" type="text" class="form-control" name="period_begin_at" value ="2019-03-30" >
                          @if ($errors->has('period_begin_at'))
                              <span class="help-block">
                  <strong>{{ $errors->first('period_begin_at') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>



                
                  <div class="form-group{{ $errors->has('period_end_at') ? ' has-error' : '' }}">
                      <label for="period_end_at" class="col-md-4 control-label">Дата окончания вылета</label>
                      <div class="col-md-6">
                          <input id="period_end_at" type="text" class="form-control" name="period_end_at" value ="2019-03-31">
                          @if ($errors->has('period_end_at'))
                              <span class="help-block">
                  <strong>{{ $errors->first('period_end_at') }}</strong>
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
                                  <option value="{{ $airline->id }}" selected>{{ $airline->code_tkp }}   {{ $airline->short_aviacompany_name_ru }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('airlines_id'))
                              <span class="help-block">
                <strong>{{ $errors->first('airlines_id') }}</strong>
                   </span>
                          @endif
                      </div>
                  </div>








               <div class="form-group{{ $errors->has('fare_families_id') ? ' has-error' : '' }}">
                      <label for="fare_families_id" class="col-md-4 control-label">Класс обслуживания</label>
                      <div class="col-md-6">
                          <select name="fare_families_id">
                              <option selected disabled>Выберите класс обслуживания</option>
                              @foreach($farefamilies as $fare_family)
                                  <option value="{{ $fare_family->id }}" selected>{{ $fare_family->name_ru }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('fare_families_id'))
                              <span class="help-block">
                <strong>{{ $errors->first('fare_families_id') }}</strong>
                   </span>
                          @endif
                      </div>
                  </div>



               <div class="form-group{{ $errors->has('fare_family_group') ? ' has-error' : '' }}">
                      <label for="fare_family_group" class="col-md-4 control-label">Группа обслуживания</label>
                      <div class="col-md-6">
                          <select name="fare_family_group">
                              <option selected disabled>Выберите группу обслуживания</option>
                              @foreach($farefamilies as $fare_family)
                                  <option value="{{ $fare_family->fare_family_group }}" selected>{{ $fare_family->fare_family_group }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('fare_family_group'))
                              <span class="help-block">
                <strong>{{ $errors->first('fare_family_group') }}</strong>
                   </span>
                          @endif
                      </div>
                  </div>




          <div class="form-group{{ $errors->has('infant') ? ' has-error' : '' }}">
                      <label for="infant" class="col-md-4 control-label">Не взимать с младенца</label>
                      <div class="col-md-6">
                          <select name="infant">
                              <option selected disabled>Выберите</option>)
                              <option value="1" selected>Да</option>
                              <option value="0">Нет</option>
                          </select>
                          @if ($errors->has('infant'))
                              <span class="help-block">
                   <strong>{{ $errors->first('infant') }}</strong>
                       </span>
                          @endif
                      </div>
                  </div>



           <div class="form-group{{ $errors->has('type_flight') ? ' has-error' : '' }}">
                      <label for="type_flight" class="col-md-4 control-label">Тип перелета</label>
                      <div class="col-md-6">
                          <select name="type_flight">
                              <option selected disabled>Выберите тип</option>
                             <option value="0" selected>Любой</option>
                            <option value="1">OW</option>
                            <option value="2">RT</option>
                          </select>
                          @if ($errors->has('type_flight'))
                              <span class="help-block">
                <strong>{{ $errors->first('type_flight') }}</strong>
                   </span>
                          @endif
                      </div>
                  </div>


                 
      <div class="form-group{{ $errors->has('country_id_departure') ? ' has-error' : '' }}">
      <label for="country_id_departure" class="col-md-4 control-label">Страна отправления </label>
        <div class="col-md-6">
        <select name="country_id_departure">
       <option selected disabled>Страна отправления</option>
       @foreach($countries as $country)
       <option value="{{ $country->id }}" selected>{{ $country->name_ru }}</option>
       @endforeach
      </select>
      @if ($errors->has('country_id_departure'))
      <span class="help-block">
     <strong>{{ $errors->first('country_id_departure') }}</strong>
        </span>
      @endif
       </div>
      </div>



      <div class="form-group{{ $errors->has('country_id_arrival') ? ' has-error' : '' }}">
      <label for="country_id_arrival" class="col-md-4 control-label">Страна назначения </label>
        <div class="col-md-6">
        <select name="country_id_arrival">
       <option selected disabled>Страна назначения</option>
       @foreach($countries as $country)
       <option value="{{ $country->id }}" selected>{{ $country->name_ru }} </option>
       @endforeach
      </select>
      @if ($errors->has('country_id_arrival'))
      <span class="help-block">
     <strong>{{ $errors->first('country_id_arrival') }}</strong>
        </span>
      @endif
       </div>
      </div>







         
  <div class="tab-pane fade" id="feesplace_order_data" role="tabpanel" aria-labelledby="feesplace_order_data-tab">
              <div class="form-group">
                  <h3>Величины сбора</h3>

             
           <div class="form-group{{ $errors->has('type_fees_inscribed') ? ' has-error' : '' }}">
                      <label for="type_fees_inscribed" class="col-md-4 control-label">Тип сбора за выписку</label>
                      <div class="col-md-6">
                          <select name="type_fees_inscribed">
                              <option selected disabled>Выберите тип</option>
                               
                              <option value="1" selected>FIX</option>
                              <option value="0">%</option>
                           
                          </select>
                          @if ($errors->has('type_fees_inscribed'))
                              <span class="help-block">
                <strong>{{ $errors->first('type_fees_inscribed') }}</strong>
                   </span>
                          @endif
                      </div>
                  </div>



             
          

 
                  <div class="form-group{{ $errors->has('size_fees_inscribed') ? ' has-error' : '' }}">
                      <label for="size_fees_inscribed" class="col-md-4 control-label">Размер сбора за выписку</label>
                      <div class="col-md-6">
                          <input id="size_fees_inscribed" type="text" class="form-control" name="size_fees_inscribed" value="0" value="{{ old('size_fees_inscribed') }}">
                          @if ($errors->has('size_fees_inscribed'))
                              <span class="help-block">
                  <strong>{{ $errors->first('size_fees_inscribed') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>


 
 
                  <div class="form-group{{ $errors->has('size_fees_charge') ? ' has-error' : '' }}">
                      <label for="size_fees_charge" class="col-md-4 control-label">Размер сбора за возврат</label>
                      <div class="col-md-6">
                          <input id="size_fees_charge" type="text" class="form-control" name="size_fees_charge" value="0" value="{{ old('size_fees_charge') }}">
                          @if ($errors->has('size_fees_charge'))
                              <span class="help-block">
                  <strong>{{ $errors->first('size_fees_charge') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>



 
                  <div class="form-group{{ $errors->has('size_fees_exchange') ? ' has-error' : '' }}">
                      <label for="size_fees_exchange" class="col-md-4 control-label">Размер сбора за обмен</label>
                      <div class="col-md-6">
                          <input id="size_fees_exchange" type="text" class="form-control" name="size_fees_exchange" value="0" value="{{ old('size_fees_exchange') }}">
                          @if ($errors->has('size_fees_exchange'))
                              <span class="help-block">
                  <strong>{{ $errors->first('size_fees_exchange') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>



 
                  <div class="form-group{{ $errors->has('max_fees_inscribed ') ? ' has-error' : '' }}">
                      <label for="max_fees_inscribed" class="col-md-4 control-label">Максимальный сбор за выписку</label>
                      <div class="col-md-6">
                          <input id="max_fees_inscribed" type="text" class="form-control" name="max_fees_inscribed" value="0" value="{{ old('max_fees_inscribed') }}">
                          @if ($errors->has('max_fees_inscribed'))
                              <span class="help-block">
                  <strong>{{ $errors->first('max_fees_inscribed') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>



 
                  <div class="form-group{{ $errors->has('max_fees_charge') ? ' has-error' : '' }}">
                      <label for="max_fees_charge" class="col-md-4 control-label">Максимальный сбор за возврат</label>
                      <div class="col-md-6">
                          <input id="max_fees_charge" type="text" class="form-control" name="max_fees_charge" value="0" value="{{ old('max_fees_charge') }}">
                          @if ($errors->has('max_fees_charge'))
                              <span class="help-block">
                  <strong>{{ $errors->first('max_fees_charge') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>

  

 
                  <div class="form-group{{ $errors->has('max_fees_exchange') ? ' has-error' : '' }}">
                      <label for="max_fees_exchange" class="col-md-4 control-label">Максимальный сбор за обмен</label>
                      <div class="col-md-6">
                          <input id="max_fees_exchange" type="text" class="form-control" name="max_fees_exchange" value="0" value="{{ old('max_fees_exchange') }}">
                          @if ($errors->has('max_fees_exchange'))
                              <span class="help-block">
                  <strong>{{ $errors->first('max_fees_exchange') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>



 


 
                  <div class="form-group{{ $errors->has('min_fees_inscribed') ? ' has-error' : '' }}">
                      <label for="min_fees_inscribed" class="col-md-4 control-label">Минимальный сбор за выписку</label>
                      <div class="col-md-6">
                          <input id="min_fees_inscribed" type="text" class="form-control" name="min_fees_inscribed" value="0" value="{{ old('min_fees_inscribed') }}">
                          @if ($errors->has('min_fees_inscribed'))
                              <span class="help-block">
                  <strong>{{ $errors->first('min_fees_inscribed') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>

 

            
                  <div class="form-group{{ $errors->has('min_fees_charge') ? ' has-error' : '' }}">
                      <label for="min_fees_charge" class="col-md-4 control-label">Минимальный сбор за возврат</label>
                      <div class="col-md-6">
                          <input id="min_fees_charge" type="text" class="form-control" name="min_fees_charge" value="0" value="{{ old('min_fees_charge') }}">
                          @if ($errors->has('min_fees_charge'))
                              <span class="help-block">
                  <strong>{{ $errors->first('min_fees_charge') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>
 
                  <div class="form-group{{ $errors->has('min_fees_exchange') ? ' has-error' : '' }}">
                      <label for="min_fees_exchange" class="col-md-4 control-label">Минимальный сбор за обмен</label>
                      <div class="col-md-6">
                          <input id="min_fees_exchange" type="text" class="form-control" name="min_fees_exchange" value="0" value="{{ old('min_fees_exchange') }}">
                          @if ($errors->has('min_fees_exchange'))
                              <span class="help-block">
                  <strong>{{ $errors->first('min_fees_exchange') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>


          <div class="form-group{{ $errors->has('non_return') ? ' has-error' : '' }}">
                      <label for="non_return" class="col-md-4 control-label">Невозвратность</label>
                      <div class="col-md-6">
                          <select name="non_return">
                              <option selected disabled>Выберите</option>)
                              <option value="1" selected>Да</option>
                              <option value="0">Нет</option>
                          </select>
                          @if ($errors->has('non_return'))
                              <span class="help-block">
                   <strong>{{ $errors->first('non_return') }}</strong>
                       </span>
                          @endif
                      </div>
                  </div>

               
    
  
                  <div class="form-group{{ $errors->has('min_fees_exchange') ? ' has-error' : '' }}">
                      <label for="min_fees_exchange" class="col-md-4 control-label">Минимальный сбор за обмен</label>
                      <div class="col-md-6">
                          <input id="min_fees_exchange" type="text" class="form-control" name="min_fees_exchange" value="0" value="{{ old('min_fees_exchange') }}">
                          @if ($errors->has('min_fees_exchange'))
                              <span class="help-block">
                  <strong>{{ $errors->first('min_fees_exchange') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>

    

               <div class="form-group{{ $errors->has('type_deviation') ? ' has-error' : '' }}">
                      <label for="type_deviation" class="col-md-4 control-label">Тип допустимого отклонения</label>
                      <div class="col-md-6">
                          <select name="type_deviation">
                              <option selected disabled>Выберите тип</option>
                           <option value="1">FIX</option>
                              <option value="0">%</option>     
                          </select>
                          @if ($errors->has('type_deviation'))
                              <span class="help-block">
                <strong>{{ $errors->first('type_deviation') }}</strong>
                   </span>
                          @endif
                      </div>
                  </div>

            

                  <div class="form-group{{ $errors->has('size_deviation') ? ' has-error' : '' }}">
                      <label for="size_deviation" class="col-md-4 control-label">  Величина отклонения</label>
                      <div class="col-md-6">
                          <input id="size_deviation" type="text" class="form-control" name="size_deviation" value="0" value="{{ old('size_deviation') }}">
                          @if ($errors->has('size_deviation'))
                              <span class="help-block">
                  <strong>{{ $errors->first('size_deviation') }}</strong>
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
