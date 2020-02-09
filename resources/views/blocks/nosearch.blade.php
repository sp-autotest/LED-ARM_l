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
                        <a href="#" class="btn btn-xs btn-success">
                            Заполнить таблицу
                        </a>
                    </div>
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
                            <th> 
                            <th> @sortablelink('schedule_id', 'Номер рейса')</th>@sortablelink('fare_families_id', 'Класс')</th>
                             <th> @sortablelink('period_begin_at', 'Период с')</th>
                              <th> @sortablelink('period_end_at', 'Период по')</th>
                               <th>Дни недели</th>
                            <th> @sortablelink('count_places', 'Количество проданных мест')</th>
                        </thead>
                        <tbody>
                       
                        </tbody>
                       {!! $blocks_search->appends(\Request::except('page'))->render() !!}
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
