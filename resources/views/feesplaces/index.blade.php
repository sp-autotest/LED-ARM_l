@extends('layouts.default')

@section('title', 'Сборы')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse">

                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="/feesplace-add" class="btn btn-xs btn-success">
                            Добавить сбор
                        </a>
                    </div>
                 
                    <h3 class="panel-title">Сборы</h3>
                </div>
                <!-- /.panel-header -->
                <div class="panel-body">

                    <form class="navbar-form col-lg-4" style="float:right;"  method="GET" action= "{{ url('/feesplace_search') }}">
                        <div class="form-group">
                            @if ($errors->has('query'))
                         <span class="help-block">
                          <strong>{{ $errors->first('query') }}</strong>
                          </span>
                            @endif
                            <input type="text" name="query" style="float:left; width:88%;" class="form-control" placeholder="Поиск" />
                            <button type="submit" style="float:right;" class="btn btn-search"><i class="fa fa-search"></i></button>
                        </div>
                    </form>


                    <table id="companies-data" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr role="row">                     
                            <th> @sortablelink('country_id_departure', 'Откуда')</th>
                            <th>  @sortablelink('country_id_arrival', 'Куда')</th>
                            <th> @sortablelink('size_fees_inscribed', 'Выписка')</th>
                            <th> @sortablelink('size_fees_charge', 'Возврат')</th>
                            <th> @sortablelink('size_fees_exchange', 'Обмен')</th>
                            <th> @sortablelink('period_end_at', 'Период продаж')</th>
                              <th> @sortablelink('period_begin_at', 'Период вылета')</th>
                            <th> @sortablelink('fare_families_id', 'Класс')</th>
                           
                            <th>@sortablelink('non_return', 'Невозвратность')</th>
                            <th> @sortablelink('company_id', 'Авиакомпания')</th>
                        </tr>
                        </thead>
                        <tbody>



                        @foreach($feesplaces as $feesplace)
                            <tr role="row" class="odd">
                                <td class="sorting_1">
                           
                                   {{$feesplace->size_fees_inscribed}}
                                   </td>
                                    <td>
                                   {{$feesplace->size_fees_charge}}
                                   </td>
                                   <td>
                                   {{$feesplace->size_fees_exchange}}
                                   </td>


                                <td>{{$feesplace->period_begin_at}}</td>
                                <td> {{$feesplace->period_end_at}}</td>
                                <td>  @foreach($farefamilies as $farefamily)
                                   @if($farefamily->id == $feesplace->fare_families_id)
                                     {{ $farefamily->name_ru}}
                                     @endif
                                  @endforeach
                               </td>
            
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
                                    <a href="{{ URL::to('feesplace-edit/'.$feesplace->id) }}">
                                        <span class="glyphicon glyphicon-wrench" title="Редактировать сбор">Редактировать сбор</span>
                                    </a>
                                </td>
                            <td>
                                

                            </td>
                            </tr>
                            <!--<tr>-->
                        @endforeach
                        </tbody>
                        {!! $feesplaces->appends(\Request::except('page'))->render() !!}
                        <tfoot>
                        <tr>
                        
                           <th rowspan="1" colspan="1">Выписка</th>
                            <th rowspan="1" colspan="1">Возврат</th>
                            <th rowspan="1" colspan="1">Обмен</th>
                            <th rowspan="1" colspan="1">Период продаж</th>
                            <th rowspan="1" colspan="1">Период вылета</th>
                            <th rowspan="1" colspan="1">Класс</th>
                            <th rowspan="1" colspan="1">Невозвратность</th>
                            <th rowspan="1" colspan="1">Авиакомпания</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

@endsection
