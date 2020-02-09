@extends('layouts.default')

@section('title', 'Страница бронирования услуги')

@section('content')

<booking-create authcompany="{{Auth::user()->company_id}}" managers="{{json_encode($managers)}}"></booking-create>

@endsection
