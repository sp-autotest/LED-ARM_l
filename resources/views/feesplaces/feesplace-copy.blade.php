

@extends('layouts.default')

@section('title', 'Сбор')


@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-inverse">

            <div class="panel-heading">
                <h3 class="panel-title">Копировать сбор</h3>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">

    <div class="container spark-screen">

    <form class="form-horizontal" role="form"  id ="/postfeeplacecopy"  method="POST" action="{{ url('/postfeeplacecopy') }}">
      <input id="feesplace_id" type="hidden" class="form-control" name="feesplace_id" value="{{ $fees->id }}"> 
      
        <input id="uid" type="hidden" class="form-control" name="uid" value="{{ Auth::user()->id }}">
  {{ csrf_field() }}
 
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



<button type="submit" class="btn btn-primary">
    Копировать
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
                              
                            <tr role="row" class="odd">
                                <td class="sorting_1">
                             
                             
                             
                                <td>{{$fees->period_begin_at}}
                                  
                                   <input id="period_begin_at" type="hidden" class="form-control" name="period_begin_at" value="{{ $fees->period_begin_at}}"> 
                                </td>
                                <td> {{$fees->period_end_at}}</td>
                           <td>  @foreach($farefamilies as $farefamily)
                                   @if($farefamily->id == $fees->fare_families_id)
                                     {{ $farefamily->name_ru}}
                                     @endif
                               
             <input id="fare_families_id" type="hidden" class="form-control" name="fare_families_id" value="{{ $farefamily->id  }}"> 
                                 @endforeach
                                <td>
                                    @if($fees->non_return > 0) 
                                    Да
                                    @else
                                    Нет
                                    @endif
                                    <input id="non_return" type="hidden" class="form-control" name="non_return" value="{{ $fees->non_return  }}"> 
                                </td>
                                <td>@foreach($airlines as $airline)
                                   @if($airline->id == $fees->airlines_id)
                                     {{ $airline->short_aviacompany_name_ru}}
                                     @endif
                                
                                   <input id="airlines_id" type="hidden" class="form-control" name="airlines_id" value="{{ $airline->id}}"> 
                                     @endforeach
                                <td>
                                  <td>{{$fees->type_fees_inscribed}}
                                   <input id="type_fees_inscribed" type="hidden" class="form-control" name="type_fees_inscribed" value="{{ $fees->type_fees_inscribed }}"> 
                                  </td>
                                <td>{{$fees->type_fees_charge}}
                                <input id="type_fees_charge" type="hidden" class="form-control" name="type_fees_charge" value="{{ $fees->type_fees_charge}}"> 
                                </td>
                                   <td> {{$fees->size_fees_inscribed}} 

                                   <input id="size_fees_inscribed" type="hidden" class="form-control" name="size_fees_inscribed" value="{{ $fees->size_fees_inscribed}}"> 
                                   </td>
                               <td>{{$fees->size_fees_charge}}
                                  <input id="size_fees_charge" type="hidden" class="form-control" name="size_fees_charge" value="{{ $fees->size_fees_charge}}"> 
                               </td>
                                <td>{{$fees->max_fees_inscribed}}
                                   <input id="max_fees_inscribed" type="hidden" class="form-control" name="max_fees_inscribed" value="{{ $fees->max_fees_inscribed}}"> 
                                
                                </td>
                                 <td>{{$fees->max_fees_charge }}
                                   <input id="max_fees_charge" type="hidden" class="form-control" name="max_fees_charge" value="{{ $fees->max_fees_charge}}"> 
                                  </td>
                                  <td>{{$fees->max_fees_exchange}}
                                    <input id="feesplace_id" type="hidden" class="form-control" name="max_fees_exchange" value="{{ $fees->max_fees_exchange }}"> 
                                  </td>
                                <td>{{$fees->min_fees_inscribed}}
                                 <input id="min_fees_inscribed" type="hidden" class="form-control" name="min_fees_inscribed" value="{{ $fees->min_fees_inscribed }}"> 
                                </td>
                               <td>{{$fees->min_fees_charge}}
                                 <input id="min_fees_charge" type="hidden" class="form-control" name="min_fees_charge" value="{{ $fees->max_fees_charge }}">   
                                
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
