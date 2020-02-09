@extends('layouts.default')

{{--
@section('htmlheader_title')
    {{ trans('blocks.title') }}
@endsection
--}}
@section('title', 'Расписание')

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
                    <h3 class="panel-title">Расписание квотируемых рейсов</h3>
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

                    <table id="companies-data" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th> 
                           @sortablelink('departure_at', 'Откуда')
                             </th>
                             <th> @sortablelink('arrival_at', 'Куда')
                             </th>
                            <th>@sortablelink('flights', 'Рейс')</th>   
                             <th> @sortablelink('period_begin_at', 'Период с')</th>
                            <th>@sortablelink('period_end_at', 'Период по')</th>
        
                            <th> @sortablelink('time_departure_at', 'Время вылета')</th>
                            <th> @sortablelink('time_ arrival_transfer_at', 'Время прибытия')</th>

                      
                             <th> @sortablelink('is_transplantation', 'Пересадка')</th>
                               <th> @sortablelink('
                            airlines_id', 'Авиакомпания')</th> 
                              <th> Дни недели 
                          </th>
                            
                          
                        
                        </tr>
                        </thead>
                        <tbody>
                       
      
                             @foreach($schedules as $schedule)
                                 <tr role="row" class="odd">
                                   <td class="sorting_1">

                              @foreach($cities  as $city)
                                   @if($city->id == $schedule->departure_at)
                                     {{ $city->name_ru}}
                                     @endif
                                  @endforeach
                                   </td>
                                         <td>    
                                   @foreach($cities  as $city)
                                   @if($city->id == $schedule->arrival_at)
                                     {{ $city->name_ru}}
                                     @endif
                                  @endforeach
                              </td>
                             <td> 
                                     {{$schedule->flights}}
                                      </td>
                                     
                                      <td>  {{$schedule->period_begin_at}}</td>
                                        <td>{{$schedule->period_end_at}}</td>
                                        
                                          <td>{{$schedule->time_departure_at}}</td>
                                           <td>{{$schedule->time_arrival_at}}</td>
                                    
                                           
                                      

                                         <td>@if($schedule->is_transplantation > 0) 
                                             Да
                                          @else
                                            Нет
                                           @endif</td> 
                                        
                                                 <td>  
                                        @foreach($airlines as $airline)
                                        @if($airline->id == $schedule->airlines_id)
                                       {{ $airline->short_aviacompany_name_ru}}
                                        @endif
                                       @endforeach
                                        </td>
                                           <td>@if($schedule->monday > 0) 
                                          Понедельник
                                          @else
                                          @endif
                                         @if($schedule->tuesday > 0) 
                                          Вторник
                                          @else
                                          @endif
                                          @if($schedule->wednesday > 0) 
                                          Среда
                                          @else
                                          @endif
                                          @if($schedule->thursday > 0) 
                                          Четверг
                                          @else
                                          @endif
                                          @if($schedule->friday > 0) 
                                          Пятница
                                          @else
                                          @endif
                                          @if($schedule->saturday > 0) 
                                          Суббота
                                          @else
                                          @endif
                                          @if($schedule->sunday > 0) 
                                          Воскресенье
                                          @else
                                          @endif
                                

                                         </td> 
                                         
                                     <td>
                                                <a href="{{ URL::to('schedule-edit/'.$schedule->id) }}">
                                                    <span class="glyphicon glyphicon-wrench" title="Редактировать расписание">Редактировать расписание</span>
                                                </a>
                                            </td>
                                        </tr>
                                      
                                          
                                   
                                        </tr>
                                      
                                    @endforeach
                                
                        </tbody>
                       {!! $schedules->appends(\Request::except('page'))->render() !!}
                        <tfoot>
              
 
                            <th rowspan="1" colspan="1">Откуда</th>
                            <th rowspan="1" colspan="1">Куда</th>
                            <th rowspan="1" colspan="1">Рейс</th>
                                  <th rowspan="1" colspan="1">Период с</th>
                            <th rowspan="1" colspan="1">Период по</th>
                              <th rowspan="1" colspan="1">Время вылета</th>
                            <th rowspan="1" colspan="1">Время прибытия</th>
                         
                           
                             <th rowspan="1" colspan="1">Пересадка</th>
                               <th rowspan="1" colspan="1">Авиакомпания</th>
                             <th rowspan="1" colspan="1">Дни недели</th>
                           
                              
                              
                          
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
