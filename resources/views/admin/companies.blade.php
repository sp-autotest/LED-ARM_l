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

                        @foreach($companies as $company)
                            <tr role="row" class="odd">
                                <td class="sorting_1">{{$company->company_name}}</td>
                                <td>{{$company->phone}}</td>
                                <td> <a href="mailto:{{$company->finance_mail}}">{{$company->finance_mail}}</a> </td>
                                <td>{{$company->first_name}}</td>
                                <td> {{  $company->third_name}}</td>
                                <td>
                                 @foreach($currencies as $currency)
                                   @if($currency->id == $company->currency_id)
                                     {{ $currency->name_ru}}
                                     @endif
                                  @endforeach
                                <td>
                                    <a href="{{ URL::to('company-edit/'.$company->id) }}">
                                        <span class="glyphicon glyphicon-wrench" title="Редактировать компанию">Редактировать компанию</span>
                                    </a>
                                </td>
                            <!--<td>
                                                <a href="{{ URL::to('company-add') }}">
                                                    <span class="glyphicon glyphicon-wrench" title="Добавить компанию">Добавить компанию</span>
                                                </a>
                                            </td>-->
                            </tr>
                            <!--<tr>-->
                        @endforeach
                        </tbody>
                        {!! $companies->appends(\Request::except('page'))->render() !!}
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
