@extends('layouts.default')

{{--
@section('htmlheader_title')
    {{ trans('blocks.title') }}
@endsection
--}}
@section('title', trans('blocks.title'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse">

                <div class="panel-heading">
                
                    <div class="panel-heading-btn">
                        <a href="{{ url('/block-add') }}" class="btn btn-xs btn-success">
                            Добавить
                        </a>
                    </div>
                    <h3 class="panel-title">Блоки</h3>
                </div>
                <!-- /.panel-header -->
                <div class="panel-body">

             <form class="navbar-form col-lg-4" style="float:right;"  role="search" method="GET" action= "{{ url('/search_block') }}">
                    
                @if ($errors->has('query'))
                     <span class="help-block">
                 <strong>{{ $errors->first('query') }}</strong>
                  </span>
                      @endif>
                       <div class="form-group">
                            <input type="text" name="query" id="query"  style="float:left; width:88%;" class="form-control" placeholder="Количество мест" />
                            <button type="submit" style="float:right;" class="btn btn-search">Поиск<i class="fa fa-search"></i></button>
                        </div>
                    </form>
                   @if (count($blocks_search) > 0) 
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
              <th> @sortablelink('schedule_id', 'Номер рейса')</th>
                            <th> @sortablelink('fare_families_id', 'Класс')</th>
                             <th> @sortablelink('period_begin_at', 'Период с')</th>
                              <th> @sortablelink('period_end_at', 'Период по')</th>
                               <th>Дни недели</th>
                            <th> @sortablelink('count_places', 'Количество проданных мест')</th>
                           
                        </tr>
                        </thead>
                        <tbody>
                       
                                   @foreach($blocks_search as $place)
                                        <tr role="row" class="odd">
                            
                             
                                 <td>@foreach($schedules  as $schedule)
                                   @if($schedule->id == $place->schedule_id)
                                     {{ $schedule->flights}}
                                     @endif
                                  @endforeach</td>

                                       <td>  @foreach($farefamilies as $farefamily)
                                   @if($farefamily->id == $place->fare_families_id)
                                     {{ $farefamily->name_ru}}
                                     @endif
                                  @endforeach
                               </td>
                                    <td> {{  $place->period_begin_at}}</td>
                                      <td> {{  $place->period_end_at}}</td>
                                          <td>
                                        @foreach($schedules  as $schedule)
                                            @if($schedule->monday > 0) 
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
                                 @endforeach

                                         </td>
                                            <td> {{$place->count_places}}</td>
                                      
                                              <td>
                                                <a href="{{ URL::to('/block-edit/'.$place->id) }}">
                                                    <span class="glyphicon glyphicon-wrench" title="Редактировать блок">Редактировать блок</span>
                                                </a>
                                            </td>
                                                  <td>
                                                <a href="{{ URL::to('/block-duplicated/'.$place->schedule_id) }}">
                                                    <span class="glyphicon glyphicon-wrench" title="Размножить Блок">Размножить блок</span>
                                                </a>
                                            </td>
                                     
                                        </tr>
                               @endforeach       
                            
                        </tbody>
                        {{--{!! $blocks_search->appends(\Request::except('page'))->render() !!}--}}
                        <tfoot>
                        <tr>
                            
                            <th rowspan="1" colspan="1">Номер Рейса</th>
                             <th rowspan="1" colspan="1">Класс</th>
                              <th rowspan="1" colspan="1">Период c</th>
                               <th rowspan="1" colspan="1">Период по</th>
                                <th rowspan="1" colspan="1">Дни недели</th>
                            <th rowspan="1" colspan="1">Количество проданных мест</th>
                           
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
