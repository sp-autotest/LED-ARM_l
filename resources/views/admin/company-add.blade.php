@extends('layouts.default')

@section('title', 'Компании')



@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-inverse">

            <div class="panel-heading">
                <h3 class="panel-title">Добавить компанию</h3>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">

    <div class="container spark-screen">

  <form class="form-horizontal" role="form"  id ="/postcompanyadd" enctype="multipart/form-data" method="POST" action="{{ url('/postcompanyadd') }}">
  {{ csrf_field() }}

      <nav class="nav desktop-tabs">
          <a class="nav-link active" href="#company_data" id="company_data-tab" data-toggle="tab" role="tab" aria-controls="company_data" aria-selected="true">Данные компании</a>
          <a class="nav-link" href="#finance_data" id="finance_data-tab" data-toggle="tab" role="tab" aria-controls="finance_data" aria-selected="false">Финансовые данные компании</a>
          <a class="nav-link" href="#director" id="director-tab" data-toggle="tab" role="tab" aria-controls="director" aria-selected="false">Руководитель компании</a>
          <a class="nav-link" href="#settings" id="settings-tab" data-toggle="tab" role="tab" aria-controls="settings" aria-selected="false">Настройки компании</a>
          <!--<a class="nav-link disabled" href="#">Disabled</a>-->
      </nav>

      <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="company_data" role="tabpanel" aria-labelledby="company_data-tab">
              <div class="form-group">
                  <h3>Данные компании</h3>

                  <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                      <label for="company_name" class="col-md-4 control-label">Название компании</label>
                      <div class="col-md-6">
                          <input id="company_name" type="text" class="form-control" name="company_name">
                          @if ($errors->has('company_name'))
                              <span class="help-block">
<strong>{{ $errors->first('company_name') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('resident') ? ' has-error' : '' }}">
                      <label for="resident" class="col-md-4 control-label">Резидент РФ</label>
                      <div class="col-md-6">
                          <select name="resident">
                              <option selected disabled>Выберите</option>)
                              <option value="1" selected>Да</option>
                              <option value="0">Нет</option>
                          </select>
                          @if ($errors->has('resident'))
                              <span class="help-block">
<strong>{{ $errors->first('resident') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('legal_company_name') ? ' has-error' : '' }}">
                      <label for="legal_company_name" class="col-md-4 control-label">Юридическое название компании</label>
                      <div class="col-md-6">
                          <input id="legal_company_name" type="text" class="form-control" name="legal_company_name">
                          @if ($errors->has('legal_company_name'))
                              <span class="help-block">
<strong>{{ $errors->first('legal_company_name') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('post_address') ? ' has-error' : '' }}">
                      <label for="post_address" class="col-md-4 control-label">Почтовый адрес</label>
                      <div class="col-md-6">
                          <input id="post_address" type="text" class="form-control" name="post_address">
                          @if ($errors->has('post_address'))
                              <span class="help-block">
<strong>{{ $errors->first('post_address') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('legal_address') ? ' has-error' : '' }}">
                      <label for="legal_address" class="col-md-4 control-label">Юридический адрес</label>
                      <div class="col-md-6">
                          <input id="legal_address" type="text" class="form-control" name="legal_address">
                          @if ($errors->has('legal_address'))
                              <span class="help-block">
<strong>{{ $errors->first('legal_address') }}</strong>
</span>
                          @endif
                      </div>
                  </div>






                  <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                      <label for="city" class="col-md-4 control-label">Город нахождения</label>
                      <div class="col-md-6">
                          <input id="city" type="text" class="form-control" name="city">
                          @if ($errors->has('city'))
                              <span class="help-block">
<strong>{{ $errors->first('city') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                      <label for="phone" class="col-md-4 control-label">Телефон</label>
                      <div class="col-md-6">
                          <input id="phone" type="text" class="form-control" name="phone">
                          @if ($errors->has('phone'))
                              <span class="help-block">
<strong>{{ $errors->first('phone') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('finance_mail') ? ' has-error' : '' }}">
                      <label for="finance_mail" class="col-md-4 control-label">E-mail для фин. уведомлений</label>
                      <div class="col-md-6">
                          <input id="finance_mail" type="text" class="form-control" name="finance_mail">
                          @if ($errors->has('finance_mail'))
                              <span class="help-block">
<strong>{{ $errors->first('finance_mail') }}</strong>
</span>
                          @endif
                      </div>
                  </div>




                  <div class="form-group{{ $errors->has('report_mail') ? ' has-error' : '' }}">
                      <label for="report_mail" class="col-md-4 control-label">E-mail для отчетов</label>
                      <div class="col-md-6">
                          <input id="report_mail" type="text" class="form-control" name="report_mail">
                          @if ($errors->has('report_mail'))
                              <span class="help-block">
<strong>{{ $errors->first('report_mail') }}</strong>
</span>
                          @endif
                      </div>
                  </div>




                  <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                      <label for="logo" class="col-md-4 control-label">Логотип компании</label>
                      <div class="col-md-6">
                          <input type="file" name="logo">
                          @if ($errors->has('logo'))
                              <span class="help-block">
<strong>{{ $errors->first('logo') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                      <label for="fax" class="col-md-4 control-label">Факс</label>
                      <div class="col-md-6">
                          <input id="fax" type="text" class="form-control" name="fax">
                          @if ($errors->has('fax'))
                              <span class="help-block">
<strong>{{ $errors->first('fax') }}</strong>
</span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('currency_company') ? ' has-error' : '' }}">
                      <label for="currency_company" class="col-md-4 control-label">Валюта компании</label>
                      <div class="col-md-6">
                          <select name="currency_company">
                              <option selected disabled>Выберите валюту</option>
                              @foreach($currencies as $currency)
                                  <option value="{{ $currency->id }}">{{ $currency->name_ru }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('currency_company'))
                              <span class="help-block">
<strong>{{ $errors->first('currency_company') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('okud') ? ' has-error' : '' }}">
                      <label for="okud" class="col-md-4 control-label">ОКУД</label>
                      <div class="col-md-6">
                          <input id="okud" type="text" class="form-control" name="okud">
                          @if ($errors->has('okud'))
                              <span class="help-block">
<strong>{{ $errors->first('okud') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('inn') ? ' has-error' : '' }}">
                      <label for="inn" class="col-md-4 control-label">ИНН</label>
                      <div class="col-md-6">
                          <input id="inn" type="text" class="form-control" name="inn">
                          @if ($errors->has('inn'))
                              <span class="help-block">
<strong>{{ $errors->first('inn') }}</strong>
</span>
                          @endif
                      </div>
                  </div>




                  <div class="form-group{{ $errors->has('okonh') ? ' has-error' : '' }}">
                      <label for="okonh" class="col-md-4 control-label">ОКОНХ</label>
                      <div class="col-md-6">
                          <input id="okonh" type="text" class="form-control" name="okonh">
                          @if ($errors->has('okonh'))
                              <span class="help-block">
<strong>{{ $errors->first('okonh') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('ogrn') ? ' has-error' : '' }}">
                      <label for="ogrn" class="col-md-4 control-label">ОГРН</label>
                      <div class="col-md-6">
                          <input id="ogrn" type="text" class="form-control" name="ogrn">
                          @if ($errors->has('ogrn'))
                              <span class="help-block">
<strong>{{ $errors->first('ogrn') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('kpp') ? ' has-error' : '' }}">
                      <label for="kpp" class="col-md-4 control-label">КПП</label>
                      <div class="col-md-6">
                          <input id="kpp" type="text" class="form-control" name="kpp">
                          @if ($errors->has('kpp'))
                              <span class="help-block">
<strong>{{ $errors->first('kpp') }}</strong>
</span>
                          @endif
                      </div>
                  </div>

              </div>
          </div>
          <div class="tab-pane fade" id="finance_data" role="tabpanel" aria-labelledby="finance_data-tab">
              <div class="form-group">
                  <h3>Финансовые данные компании</h3>

                  <div class="form-group{{ $errors->has('bank_name') ? ' has-error' : '' }}">
                      <label for="bank_name" class="col-md-4 control-label">Название банка</label>
                      <div class="col-md-6">
                          <input id="bank_name" type="text" class="form-control" name="bank_name">
                          @if ($errors->has('bank_name'))
                              <span class="help-block">
<strong>{{ $errors->first('bank_name') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('сhecking_account') ? ' has-error' : '' }}">
                      <label for="сhecking_account" class="col-md-4 control-label">Номер расч. счета</label>
                      <div class="col-md-6">
                          <input id="сhecking_account" type="text" class="form-control" name="сhecking_account">
                          @if ($errors->has('сhecking_account'))
                              <span class="help-block">
<strong>{{ $errors->first('сhecking_account') }}</strong>
</span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('bik') ? ' has-error' : '' }}">
                      <label for="bik" class="col-md-4 control-label">БИК</label>
                      <div class="col-md-6">
                          <input id="bik" type="text" class="form-control" name="bik">
                          @if ($errors->has('bik'))
                              <span class="help-block">
<strong>{{ $errors->first('bik') }}</strong>
</span>
                          @endif
                      </div>
                  </div>





                  <div class="form-group{{ $errors->has('correspondent_account') ? ' has-error' : '' }}">
                      <label for="correspondent_account" class="col-md-4 control-label">Корреспондентский счет</label>
                      <div class="col-md-6">
                          <input id="correspondent_account" type="text" class="form-control" name="correspondent_account">
                          @if ($errors->has('correspondent_account'))
                              <span class="help-block">
<strong>{{ $errors->first('correspondent_account') }}</strong>
</span>
                          @endif
                      </div>
                  </div>

              </div>
          </div>
          <div class="tab-pane fade" id="director" role="tabpanel" aria-labelledby="director-tab">
              <div class="form-group">

                  <h3>Руководитель компании</h3>

                  <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                      <label for="first_name" class="col-md-4 control-label">Имя</label>
                      <div class="col-md-6">
                          <input id="first_name" type="text" class="form-control" name="first_name">
                          @if ($errors->has('first_name'))
                              <span class="help-block">
<strong>{{ $errors->first('first_name') }}</strong>
</span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('second_name') ? ' has-error' : '' }}">
                      <label for="second_name" class="col-md-4 control-label">Отчество</label>
                      <div class="col-md-6">
                          <input id="second_name" type="text" class="form-control" name="second_name">
                          @if ($errors->has('second_name'))
                              <span class="help-block">
<strong>{{ $errors->first('second_name') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('third_name') ? ' has-error' : '' }}">
                      <label for="third_name" class="col-md-4 control-label">Фамилия</label>
                      <div class="col-md-6">
                          <input id="third_name" type="text" class="form-control" name="third_name">
                          @if ($errors->has('third_name'))
                              <span class="help-block">
<strong>{{ $errors->first('third_name') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                      <label for="position" class="col-md-4 control-label">Должность</label>
                      <div class="col-md-6">
                          <input id="position" type="text" class="form-control" name="position">
                          @if ($errors->has('position'))
                              <span class="help-block">
<strong>{{ $errors->first('position') }}</strong>
</span>
                          @endif
                      </div>
                  </div>

              </div>
          </div>
          <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
              <div class="form-group">
                  <h3>Настройки компании</h3>
                  <div class="form-group{{ $errors->has('agreement') ? ' has-error' : '' }}">
                      <label for="agreement" class="col-md-4 control-label">Условия оплаты</label>
                      <div class="col-md-6">
                          <input id="agreement" type="text" class="form-control" name="agreement">
                          @if ($errors->has('agreement'))
                              <span class="help-block">
<strong>{{ $errors->first('agreement') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('contract_number') ? ' has-error' : '' }}">
                      <label for="contract_number" class="col-md-4 control-label">Договор №</label>
                      <div class="col-md-6">
                          <input id="contract_number" type="text" class="form-control" name="contract_number">
                          @if ($errors->has('contract_number'))
                              <span class="help-block">
<strong>{{ $errors->first('contract_number') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('contract_date') ? ' has-error' : '' }}">
                      <label for="contract_date" class="col-md-4 control-label">Дата договора</label>
                      <div class="col-md-6">
                          <input id="contract_date" type="text" class="form-control" name="contract_date">
                          @if ($errors->has('contract_date'))
                              <span class="help-block">
<strong>{{ $errors->first('contract_date') }}</strong>
</span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('manager_id') ? ' has-error' : '' }}">
                      <label for="manager_id" class="col-md-4 control-label">Менеджеры</label>
                      <div class="col-md-6">
                          <select  name="manager_id">
                              <option selected disabled>Выберите менеджера  из списка</option>
                              @foreach($managers as $manager)
                                  <option value="{{ $manager->id }}" selected>{{ $manager->first_name}} {{ $manager->second_name}}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('manager_id'))
                              <span class="help-block">
<strong>{{ $errors->first('manager_id') }}</strong>
</span>
                          @endif
                      </div>
                  </div>





                  <div class="form-group{{ $errors->has('commission_business') ? ' has-error' : '' }}">
                      <label for="commission_business" class="col-md-4 control-label">Комиссия бизнес</label>
                      <div class="col-md-6">
                          <input id="commission_business" type="text" class="form-control" name="commission_business">
                          @if ($errors->has('commission_business'))
                              <span class="help-block">
<strong>{{ $errors->first('commission_business') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('commission_first') ? ' has-error' : '' }}">
                      <label for="commission_first" class="col-md-4 control-label">Комиссия первый</label>
                      <div class="col-md-6">
                          <input id="commission_first" type="text" class="form-control" name="commission_first">
                          @if ($errors->has('commission_first'))
                              <span class="help-block">
<strong>{{ $errors->first('commission_first') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('commission_economy') ? ' has-error' : '' }}">
                      <label for="commission_economy" class="col-md-4 control-label">Комиссия эконом</label>
                      <div class="col-md-6">
                          <input id="commission_economy" type="text" class="form-control" name="commission_business">
                          @if ($errors->has('commission_economy'))
                              <span class="help-block">
<strong>{{ $errors->first('commission_economy') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                      <label for="status" class="col-md-4 control-label">Статус компании</label>
                      <div class="col-md-6">
                          <select name="status">
                              <option selected disabled>Выберите</option>)
                              <option value="1" selected>Активный</option>
                              <option value="0">Неактивный</option>
                          </select>
                          @if ($errors->has('status'))
                              <span class="help-block">
<strong>{{ $errors->first('status') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('limit') ? ' has-error' : '' }}">
                      <label for="limit" class="col-md-4 control-label">Использовать лимит баланса</label>
                      <div class="col-md-6">
                          <select name="limit">
                              <option selected disabled>Выберите</option>)
                              <option value="1" selected>Да</option>
                              <option value="0">Нет</option>
                          </select>
                          @if ($errors->has('limit'))
                              <span class="help-block">
<strong>{{ $errors->first('limit') }}</strong>
</span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group{{ $errors->has('residue_limit') ? ' has-error' : '' }}">
                      <label for="residue_limit" class="col-md-4 control-label">Лимит остатка</label>
                      <div class="col-md-6">
                          <input id="residue_limit" type="text" class="form-control" name="residue_limit">
                          @if ($errors->has('residue_limit'))
                              <span class="help-block">
<strong>{{ $errors->first('residue_limit') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('invoice_payment') ? ' has-error' : '' }}">
                      <label for="invoice_payment" class="col-md-4 control-label">Возможность оплаты по счету</label>
                      <div class="col-md-6">
                          <select name="invoice_payment">
                              <option selected disabled>Выберите</option>)
                              <option value="1" selected>Да</option>
                              <option value="0">Нет</option>
                          </select>
                          @if ($errors->has('invoice_payment'))
                              <span class="help-block">
<strong>{{ $errors->first('invoice_payment') }}</strong>
</span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group{{ $errors->has('fees_avia') ? ' has-error' : '' }}">
                      <label for="fees_avia" class="col-md-4 control-label">Помещать сборы в таксу Авиа</label>
                      <div class="col-md-6">
                          <select name="fees_avia">
                              <option selected disabled>Выберите</option>)
                              <option value="1" selected>Активный</option>
                              <option value="0">Неактивный</option>
                          </select>
                          @if ($errors->has('fees_avia'))
                              <span class="help-block">
<strong>{{ $errors->first('fees_avia') }}</strong>
</span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('support_contacts') ? ' has-error' : '' }}">
                      <label for="support_contacts" class="col-md-4 control-label">Контакты службы поддержки</label>
                      <div class="col-md-6">
                          <textarea class="form-control" rows="5" class="form-control" name="support_contacts"></textarea>
                          @if ($errors->has('support_contacts'))
                              <span class="help-block">
<strong>{{ $errors->first('support_contacts') }}</strong>
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
