@extends('layouts.default')

@section('title', 'Сбор')



@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-inverse">

            <div class="panel-heading">
                <h3 class="panel-title">Добавить сбор</h3>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">

    <div class="container spark-screen">
  <form class="form-horizontal" role="form"  id ="/add_payment"  method="POST" action="{{ url('/add_payment') }}">
  <input id="uid" type="hidden" class="form-control" name="uid" value="{{ Auth::user()->id }}">
  {{ csrf_field() }}
     <nav class="nav desktop-tabs">
          <a class="nav-link active" href="#feesplace_data" id="feesplace_data-tab" data-toggle="tab" role="tab" aria-controls="feesplace_data" aria-selected="true">Параметры заказа</a>
          <a class="nav-link" href="#feesplace_order_data" id="finance_order_data-tab" data-toggle="tab" role="tab" aria-controls="feesplace_order_data" aria-selected="false">Величины сбора</a>
          <!--<a class="nav-link disabled" href="#">Disabled</a>-->
      </nav>


    
      <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="feesplace_data" role="tabpanel" aria-labelledby="feesplace_data-tab">
              <div class="form-group">
                  <h3>Параметры заказа</h3>

              <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
<label for="company_id" class="col-md-4 control-label">Название компании</label>
<div class="col-md-6">
<select  name="company_id">
<option selected disabled>Выберите компанию</option>
@foreach($companies as $company)
      <option value="{{ $company->id }}" selected>{{ $company->company_name}}</option>
     @endforeach
    </select>  
@if ($errors->has('company_id'))
<span class="help-block">
<strong>{{ $errors->first('company_id') }}</strong>
</span>
 @endif
 </div>
</div>



                  <div class="form-group{{ $errors->has('ammount') ? ' has-error' : '' }}">
                      <label for="ammount" class="col-md-4 control-label">ammount</label>
                      <div class="col-md-6">
                          <input id="date_start" type="text" class="form-control" name="ammount" >
                          @if ($errors->has('ammount'))
                              <span class="help-block">
                  <strong>{{ $errors->first('ammount') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>



        
 
                  <div class="form-group{{ $errors->has('pay_date') ? ' has-error' : '' }}">
                      <label for="pay_date" class="col-md-4 control-label">pay_date</label>
                      <div class="col-md-6">
                          <input id="pay_date" type="text" class="form-control" name="pay_date" value ="2019-03-30">
                          @if ($errors->has('pay_date'))
                              <span class="help-block">
                  <strong>{{ $errors->first('pay_date') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>


 
 
                  <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                      <label for="comment" class="col-md-4 control-label">comment</label>
                      <div class="col-md-6">
                          <input id="comment" type="text" class="form-control" name="comment">
                          @if ($errors->has('comment'))
                              <span class="help-block">
                  <strong>{{ $errors->first('comment') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>



 


 
  

       
               
    
  
                  <div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                      <label for="account_number" class="col-md-4 control-label">account_number</label>
                      <div class="col-md-6">
                          <input id="account_number" type="text" class="form-control" name="account_number" >
                          @if ($errors->has('account_number'))
                              <span class="help-block">
                  <strong>{{ $errors->first('account_number') }}</strong>
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
