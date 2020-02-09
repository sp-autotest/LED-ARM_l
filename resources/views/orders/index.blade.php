@extends('layouts.default')


@section('title', 'Заказы')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse">

                    <h3 class="panel-title">Список заказов</h3>
                </div>
                <!-- /.panel-header -->
                <div class="panel-body">
                  <h3 class="section-title">Поиск заказа:</h3>
 <div class="form-group">
 <form class="typeahead" role="search" method="GET" action= "{{ url('/search_order') }}">
<div class="form-group">
@if ($errors->has('query'))
<span class="help-block">
<strong>{{ $errors->first('query') }}</strong>
</span>
@endif
<input type="search" name="query" id="query" placeholder="Введите номер заказа" type="search">
</div>
<div class="form-group">
<input id="btn-submit" class="btn btn-send-message btn-md" value="Поиск" type="submit">
<span class="glyphicon glyphicon-search"></span>
 </button>
</div>
</form>
                 @if ($count_orders > 0)

                    <table id="companies-data" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th> 
                           Заказ
                             </th>
                             <th> 
                              Дата создания
                             </th>
                            <th>Клиент</th>   
                             <th>Автор</th>
                        </tr>
                        </thead>
                        <tbody>
                       
      
                             @foreach($orders as $order)
                                 <tr role="row" class="odd">
                                   <td>  
                                 {{$order->order_n}}
                                 Статус
                                 {{$order->status}}
                              
                                   </td>
                               <td>    
                                   {{$order->created_at}}
                              </td>
                             <td> 
                                  @foreach($companies as $company)
                                        @if($company->id == $order->company_registry_id)
                                       {{ $company->company_name}}
                                        @endif
                                       @endforeach


                                     {{$order->company_registry_id}}
                                     Сумма заказа
                                      {{$order->order_summary}} рублей
                                     
                                      </td>
                                     
                                      <td> 
                                   
                                        @if($profile->id == $order->user_id)
                                       {{ $profile->first_name}}
                                       {{ $profile->last_name}}
                                        @endif
                                      

                                     </td>
                                      
                        
                                         
                               
                                        </tr>
                                      
                                          
                                   
                                        </tr>
                                      
                                    @endforeach
                                
                        </tbody>
                       {{!! $orders->links() !!}}
                        <tfoot>
                     @else
                     <p>Нет заказов на данный момент</p>
                     @endif
 
                       
                         
                              
                              
                          
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
