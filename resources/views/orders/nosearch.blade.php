@extends('layouts.default')


@section('title', 'Заказы')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse">

             
                    <h3 class="panel-title">Поиска заказов</h3>
                </div>
                <!-- /.panel-header -->
                <div class="panel-body">
              
       <form class="navbar-form col-lg-4" style="float:right;"  role="search" method="GET" action= "{{ url('/search_order') }}">
                    
                @if ($errors->has('query'))
                     <span class="help-block">
                 <strong>{{ $errors->first('query') }}</strong>
                  </span>
                      @endif>
                       <div class="form-group">
                            <input type="text" name="query" id="query"  style="float:left; width:88%;" class="form-control" placeholder="Введите номер заказа" />
                            <button type="submit" style="float:right;" class="btn btn-search">Поиск<i class="fa fa-search"></i></button>
                        </div>
                    </form>
                   
@if (count($order_search) > 0) 
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
                           @sortablelink('created_at', 'Дата создания')
                             </th>
                             <th> @sortablelink('order_n', 'Номер заказа')
                             </th>
                            <th>@sortablelink('status', 'Статус заказа')</th>   
                             <th> @sortablelink('type_order', 'Тип заказа')</th>
                            <th>@sortablelink('company_registry_id', 'Клиент')</th>
        
                            <th> @sortablelink('user_id', 'Автор заказа')</th>
                             <th> @sortablelink('order_summary', 'Сумма заказа')</th>
                            <th> @sortablelink('passengers', 'Количество пассажиров')</th>
                        
    
                               <th> @sortablelink('
                            services', 'Количество добавленных услуг')</th> 

                        </tr>
                        </thead>
                        <tbody>
                       
    
                                 <tr role="row" class="odd">
                                   <td class="sorting_1">

                              </td>
                             <td> 
                         
                                
                        </tbody>
                     
                        <tfoot>
              
 
                      
                              
                              
                          
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
