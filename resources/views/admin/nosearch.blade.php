
@extends('layouts.default')

@section('title', 'Компании')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse">

                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="/company-add" class="btn btn-xs btn-success">
                            Добавить
                        </a>
                    </div>
                    <h3 class="panel-title">Компании</h3>
                </div>
                <!-- /.panel-header -->
                <div class="panel-body">
                <div class="form-group">
               <form class="navbar-form col-lg-4" style="float:right;"  role="search" method="GET" action= "{{ url('/search_company') }}">
                    
                @if ($errors->has('query'))
                     <span class="help-block">
                 <strong>{{ $errors->first('query') }}</strong>
                  </span>
                      @endif>
                        <div class="form-group">
                            <input type="text" name="query" id="query"  style="float:left; width:88%;" class="form-control" placeholder="Поиск" />
                            <button type="submit" style="float:right;" class="btn btn-search"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
@if (count($company_search) > 0) 
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
                            <th> @sortablelink('company_name', 'Название компании')</th>
                            <th> @sortablelink('phone', 'Телефон')</th>
                            <th> @sortablelink('finance_mail', 'E-mail')</th>
                            <th>@sortablelink('first_name', 'Имя Менеджера')</th>
                            <th>@sortablelink('third_name', 'Фамилия Менеджера')</th>
                            <th> @sortablelink('currency_company', 'Валюта компании')</th>
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
                            <th rowspan="1" colspan="1">Название компании</th>
                            <th rowspan="1" colspan="1">Телефон</th>
                            <th rowspan="1" colspan="1">Email</th>
                            <th rowspan="1" colspan="1">Имя Менеджера</th>
                            <th rowspan="1" colspan="1">Фамилия Менеджера</th>
                            <th rowspan="1" colspan="1">Валюта компании</th>
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
