
@extends('layouts.default')

@section('title', 'Статус')



@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-inverse">

            <div class="panel-heading">
                <h3 class="panel-title">Статус</h3>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">

    <div class="container spark-screen">

  <form class="form-horizontal" role="form"  id ="/post_bc"  method="POST" action="{{ url('/post_bc') }}">
  {{ csrf_field() }}


    
      <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="feesplace_data" role="tabpanel" aria-labelledby="feesplace_data-tab">
              <div class="form-group">
                

  
 <div class="form-group">
   <h3>Добавить</h3>

          <div class="form-group{{ $errors->has('name_eng') ? ' has-error' : '' }}">
                      <label for="name_eng" class="col-md-4 control-label"> name_eng</label>
                      <div class="col-md-6">
                          <input id="name_eng" type="text" class="form-control" name="name_eng">
                          @if ($errors->has('name_eng'))
                              <span class="help-block">
                  <strong>{{ $errors->first('name_eng') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>


       <div class="form-group{{ $errors->has('name_ru') ? ' has-error' : '' }}">
                      <label for="name_eng" class="col-md-4 control-label"> name_ru</label>
                      <div class="col-md-6">
                          <input id="name_eng" type="text" class="form-control" name="name_ru">
                          @if ($errors->has('name_ru'))
                              <span class="help-block">
                  <strong>{{ $errors->first('name_ru') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>


     <div class="form-group{{ $errors->has('aircraft_class_code') ? ' has-error' : '' }}">
                      <label for="aircraft_class_code" class="col-md-4 control-label">aircraft_class_code</label>
                      <div class="col-md-6">
                          <input id="aircraft_class_code" type="text" class="form-control" name="aircraft_class_code">
                          @if ($errors->has('aircraft_class_code'))
                              <span class="help-block">
                  <strong>{{ $errors->first('aircraft_class_code') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>


    <div class="form-group{{ $errors->has('ccp') ? ' has-error' : '' }}">
                      <label for="ccp" class="col-md-4 control-label">ccp</label>
                      <div class="col-md-6">
                          <input id="ccp" type="text" class="form-control" name="ccp">
                          @if ($errors->has('ccp'))
                              <span class="help-block">
                  <strong>{{ $errors->first('ccp') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>


     
      


              </div>
          </div>
      </div>

      <div class="form-group">
<div class="col-md-6 col-md-offset-4">
<button type="submit" class="btn btn-primary">
    Добавить
</button>
</div>
</div>
  </form>
    </div>

</div>
</div>
</div>
</div>
</div>
@endsection
