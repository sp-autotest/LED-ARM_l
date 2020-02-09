@extends('layouts.empty', ['paceTop' => true])

@section('title', 'Вход')

@section('content')
    <div class="login-cover">
        <div class="login-cover-image" style="background-color: #EEEEEE !important" ></div>
    </div>
    <!-- begin login -->

    <span class="login-logo"><img src="/logo_itm.png" style="max-height: 100%;"></span>

    <div class="login login-v2" data-pageload-addclass="animated fadeIn">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                Авторизация
                <small>Войдите в учетную запись агента</small>
            </div>
            <!--
            <div class="icon">
                <i class="fa fa-lock"></i>
            </div>
            -->
        </div>
        <!-- end brand -->
        <!-- begin login-content -->
        <div class="login-content">
            <form method="POST" action="{{ route('login') }}" class="margin-bottom-0">
                @csrf
                <label for="email">Логин</label>
                <div class="form-group m-b-20 form-group-lg inner-addon">
                    <i class="fa fa-user"></i>
                    <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Введите ваш логин" required />
                </div>
                <label for="password">Пароль</label>
                <div class="form-group m-b-20 form-group-lg inner-addon">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Введите ваш пароль" required />
                </div>
                <!--				<div class="checkbox checkbox-css m-b-20">
                                    <input type="checkbox" id="remember_checkbox" name="remember"/>
                                    <label for="remember_checkbox">
                                        Remember Me
                                    </label>
                                </div>
                                <div class="login-buttons">
                                    <button type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
                                </div>
                                <div class="m-t-20">
                                    Not a member yet? Click <a href="/register">here</a> to register.
                                </div>-->
                <div class="login-buttons">
                    <button type="submit" class="btn btn-success btn-block btn-lg">Войти</button>
                </div>
            </form>
        </div>
        <!-- end login-content -->
    </div>
    <!-- end login -->

    <!-- 	<ul class="login-bg-list clearfix">
            <li class="active"><a href="javascript:;" data-click="change-bg" data-img="../assets/img/login-bg/login-bg-17.jpg" style="background-image: url(../assets/img/login-bg/login-bg-17.jpg)"></a></li>
            <li><a href="javascript:;" data-click="change-bg" data-img="../assets/img/login-bg/login-bg-16.jpg" style="background-image: url(../assets/img/login-bg/login-bg-16.jpg)"></a></li>
            <li><a href="javascript:;" data-click="change-bg" data-img="../assets/img/login-bg/login-bg-15.jpg" style="background-image: url(../assets/img/login-bg/login-bg-15.jpg)"></a></li>
            <li><a href="javascript:;" data-click="change-bg" data-img="../assets/img/login-bg/login-bg-14.jpg" style="background-image: url(../assets/img/login-bg/login-bg-14.jpg)"></a></li>
            <li><a href="javascript:;" data-click="change-bg" data-img="../assets/img/login-bg/login-bg-13.jpg" style="background-image: url(../assets/img/login-bg/login-bg-13.jpg)"></a></li>
            <li><a href="javascript:;" data-click="change-bg" data-img="../assets/img/login-bg/login-bg-12.jpg" style="background-image: url(../assets/img/login-bg/login-bg-12.jpg)"></a></li>
        </ul>
        -->
@endsection

@push('scripts')
    <script src="/assets/js/demo/login-v2.demo.js"></script>
    <script>
      $(document).ready(function() {
        LoginV2.init();
      });
    </script>
@endpush
