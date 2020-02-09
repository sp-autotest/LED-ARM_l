

@extends('layouts.default')

@section('title', 'Сбор')


@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-inverse">

            <div class="panel-heading">
                <h3 class="panel-title">Копировать сбор с заменой</h3>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">

    <div class="container spark-screen">

    <form class="form-horizontal" role="form"  id ="/postfeeplacecopyreplace"  method="POST" action="{{ url('/postfeeplacecopyreplace') }}">
    <input id="uid" type="hidden" class="form-control" name="uid" value="{{ Auth::user()->id }}">
  {{ csrf_field() }}
 
<div class="form-group{{ $errors->has('company_id1') ? ' has-error' : '' }}">
<label for="company_id1" class="col-md-4 control-label">Начальная компания:Откуда копировать</label>
<div class="col-md-6">
<select  name="company_id1">
<option selected disabled>Выберите компанию</option>
@foreach($companies as $company)
      <option value="{{ $company->id }}" selected>{{ $company->company_name}}</option>
     @endforeach
    </select>  
@if ($errors->has('company_id1'))
<span class="help-block">
<strong>{{ $errors->first('company_id1') }}</strong>
</span>
 @endif
 </div>
</div>

 
<div class="form-group{{ $errors->has('company_id2') ? ' has-error' : '' }}">
<label for="company_id2" class="col-md-4 control-label">Конечная  компания:Куда копировать</label>
<div class="col-md-6">
<select  name="company_id2">
<option selected disabled>Выберите компанию</option>
@foreach($companies as $company)
      <option value="{{ $company->id }}" selected>{{ $company->company_name}}</option>
     @endforeach
    </select>  
@if ($errors->has('company_id2'))
<span class="help-block">
<strong>{{ $errors->first('company_id2') }}</strong>
</span>
 @endif
 </div>
</div>




<button type="submit" class="btn btn-primary">
    Начать Копирование
</button>
<br>
<br>

                  <table id="companies-data" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr role="row">                     
                           
                            <th>Период вылета</th>
                            <th>Период продаж</th>
                            <th>Класс</th>
                            <th>Невозвратность</th>
                            <th>Авиакомпания</th>
                            <th>Тип сбора за выписку</th>
                             <th>Тип сбора за возврат</th>
                             <th>Размер сбора за выписку</th>
                             <th>Размер сбора за возврат</th>
                             <th>Размер сбора за обмен</th>
                             <th>Максимальный сбор за выписку</th>
                             <th>Максимальный сбор за возврат</th>
                            <th>Максимальный сбор за обмен</th>
                            <th>Минимальный сбор за выписку</th>
                            <th>Минимальный сбор за возврат</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                             @foreach($feesplaces  as $feesplace)  
                            <tr role="row" class="odd">
                            
                             
                                <td>{{$feesplace->period_begin_at}}
                                  
                                   
                                </td>
                                <td> {{$feesplace->period_end_at}}</td>
                           <td>  @foreach($farefamilies as $farefamily)
                                   @if($farefamily->id == $feesplace->fare_families_id)
                                     {{ $farefamily->name_ru}}
                                     @endif
                               
             
                                 @endforeach
                                <td>
                                    @if($feesplace->non_return > 0) 
                                    Да
                                    @else
                                    Нет
                                    @endif
                                    
                                </td>
                                <td>@foreach($airlines as $airline)
                                   @if($airline->id == $feesplace->airlines_id)
                                     {{ $airline->short_aviacompany_name_ru}}
                                     @endif
                                
                                     @endforeach
                                <td>
                                  <td>{{$feesplace->type_fees_inscribed}}
                                  
                                  </td>
                                <td>{{$feesplace->type_fees_charge}}
                              
                                </td>
                                   <td> {{$feesplace->size_fees_inscribed}} 

                                  
                                   </td>
                               <td>{{$feesplace->size_fees_charge}}
                                
                               </td>
                                <td>{{$feesplace->max_fees_inscribed}}
                                  
                                
                                </td>
                                 <td>{{$feesplace->max_fees_charge }}
                                  
                                  </td>
                                  <td>{{$feesplace->max_fees_exchange}}
                                  
                                  </td>
                                <td>{{$feesplace->min_fees_inscribed}}
                                
                                </td>
                               <td>{{$feesplace->min_fees_charge}}
                                 
                                @endforeach
                               </td>
                               

                            </tr>
                           
                
                        </tbody>
                       
                        <tfoot>
                        <tr>
                           
                    
                            <th rowspan="1" colspan="1">Период вылета</th>
                            <th rowspan="1" colspan="1">Период продаж</th>
                            <th rowspan="1" colspan="1">Класс</th>
            
                            <th rowspan="1" colspan="1">Невозвратность</th>
                            <th rowspan="1" colspan="1">Компания</th>
                             <th rowspan="1" colspan="1">Тип сбора за выписку</th>
                            <th rowspan="1" colspan="1">Тип сбора за возврат</th>
                            <th rowspan="1" colspan="1">Размер сбора за выписку</th>
                            <th rowspan="1" colspan="1">Размер сбора за возврат</th>
                            <th rowspan="1" colspan="1">Размер сбора за обмен</th>
                            <th rowspan="1" colspan="1">Максимальный сбор за выписку</th>
                            <th rowspan="1" colspan="1">Максимальный сбор за возврат</th>
                              <th rowspan="1" colspan="1">Максимальный сбор за обмен</th>
                             <th rowspan="1" colspan="1">Минимальный сбор за выписку</th>
                               <th rowspan="1" colspan="1">Минимальный сбор за возврат</th>
                         

                        </tr>
                        </tfoot>
                    </table>
  
    


            
              </div>
          </div>
      </div>

      <div class="form-group">
<div class="col-md-6 col-md-offset-4">

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
