@extends('layouts.default')

{{--
@section('htmlheader_title')
    {{ trans('blocks.title') }}
@endsection
--}}
@section('title', trans('schedules.title'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse">

                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="{{ url('/schedule-add') }}" class="btn btn-xs btn-success">
                            Добавить
                        </a>
                    </div>
                    <h3 class="panel-title">Расписания</h3>
                </div>
                <!-- /.panel-header -->
                <div class="panel-body">
              
         <form class="navbar-form col-lg-4" style="float:right;"  role="search" method="GET" action= "{{ url('/search_sсhedule') }}">
                    
                @if ($errors->has('query'))
                     <span class="help-block">
                 <strong>{{ $errors->first('query') }}</strong>
                  </span>
                      @endif>
                      <div class="form-group">
                            <input type="text" name="query" id="query"  style="float:left; width:88%;" class="form-control" placeholder="Введите номер рейса" />
                            <button type="submit" style="float:right;" class="btn btn-search">Поиск<i class="fa fa-search"></i></button>
                        </div>
                    </form>

                   
@if (count($schedule_search) > 0) 
 <h3>Результаты поиска: <i>{{$query}} </i></h3>
 <h3>Обнаружено: {{$total}} совпадений</h3>    
<div class="row text-center">             
@else
 <h3>Результаты поиска: <i>{{$query}} </i></h3>
 <h3>Обнаружено: {{$total}} совпадений</h3> 
@endif

                    <table id="companies-data" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                   
                            <th>@sortablelink('flights', 'Рейс')</th>
                             <th> @sortablelink('period_begin_at', 'Период с')</th>
                            <th>@sortablelink('period_end_at', 'Период по')</th>
                            <th> @sortablelink('time_departure_at', 'Время вылета')</th>
                            <th> @sortablelink('time_ arrival_transfer_at', 'Время прибытия')</th>
                            <th> @sortablelink('is_transplantation', 'Пересадка')</th>
                          
                             <th> @sortablelink('
                            airlines_id', 'Аавиакомпания')</th> 

                        </tr>
                        </tr>
                        </thead>
                        <tbody>
                       
                           <tr role="row" class="odd">
                                            <td class="sorting_1"> 
                                
                                            </td>
                                     
                                        </tr>
                                  
                                
                        </tbody>
                    
                        <tfoot>
                        <tr>
                  
                            <th rowspan="1" colspan="1">Рейс</th>
                            <th rowspan="1" colspan="1">Период с</th>
                            <th rowspan="1" colspan="1">Период по</th>
                            <th rowspan="1" colspan="1">Время вылета</th>
                            <th rowspan="1" colspan="1">Время прибытия</th>
                             <th rowspan="1" colspan="1">Пересадка</th>
                              <th rowspan="1" colspan="1">Авиакомпания</th>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
