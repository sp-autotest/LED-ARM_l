@extends('layouts.default')

@section('title', 'Рабочий Стол')

@push('css')
    <link href="/assets/plugins/jquery-jvectormap/jquery-jvectormap.min.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse">

            <div class="panel-heading">
                <h3 class="panel-title">Рабочий стол</h3>
            </div>
            <!-- /.panel-header -->
                <div class="panel-body">

                    <nav class="nav desktop-tabs">
                        <a class="nav-link active" href="#orders" id="orders-tab" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="true">Заказы</a>
                        <a class="nav-link" href="#services" id="services-tab" data-toggle="tab" role="tab" aria-controls="services" aria-selected="false">Услуги</a>
                        <a class="nav-link" href="#messages" id="messages-tab" data-toggle="tab" role="tab" aria-controls="messages" aria-selected="false">Сообщения</a>
                        <!--<a class="nav-link disabled" href="#">Disabled</a>-->
                    </nav>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                            Тут будет контент вкладки заказов
                        </div>
                        <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                            Тут будет контент вкладки услуг
                        </div>
                        <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                            Тут будет контент вкладки сообщений
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


  <!-- begin breadcrumb
  <ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  <!-- end breadcrumb -->
  <!-- begin page-header
  <h1 class="page-header">Dashboard <small>header small text goes here...</small></h1>
  <!-- end page-header -->
  
  <!-- begin row
  <div class="row">
    <!-- begin col-3
    <div class="col-lg-3 col-md-6">
      <div class="widget widget-stats bg-red">
        <div class="stats-icon"><i class="fa fa-desktop"></i></div>
        <div class="stats-info">
          <h4>TOTAL VISITORS</h4>
          <p>3,291,922</p>  
        </div>
        <div class="stats-link">
          <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
        </div>
      </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3
    <div class="col-lg-3 col-md-6">
      <div class="widget widget-stats bg-orange">
        <div class="stats-icon"><i class="fa fa-link"></i></div>
        <div class="stats-info">
          <h4>BOUNCE RATE</h4>
          <p>20.44%</p> 
        </div>
        <div class="stats-link">
          <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
        </div>
      </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3
    <div class="col-lg-3 col-md-6">
      <div class="widget widget-stats bg-grey-darker">
        <div class="stats-icon"><i class="fa fa-users"></i></div>
        <div class="stats-info">
          <h4>UNIQUE VISITORS</h4>
          <p>1,291,922</p>  
        </div>
        <div class="stats-link">
          <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
        </div>
      </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3
    <div class="col-lg-3 col-md-6">
      <div class="widget widget-stats bg-black-lighter">
        <div class="stats-icon"><i class="fa fa-clock"></i></div>
        <div class="stats-info">
          <h4>AVG TIME ON SITE</h4>
          <p>00:12:23</p> 
        </div>
        <div class="stats-link">
          <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
        </div>
      </div>
    </div>
    <!-- end col-3
  </div>
  <!-- end row -->
  
@endsection

@push('scripts')
@endpush
