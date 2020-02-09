@extends('layouts.default')

@section('title', 'Поиск рейса')


@section('content')
<crane-search auth_user="{{Auth::user()->id}}" authcompany="{{Auth::user()->company_id}}" managers="{{json_encode($managers)}}"></crane-search>

@endsection


  