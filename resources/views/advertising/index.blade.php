@extends('layouts.default')

@section('title', 'Маршрут-квитанция')

@section('content')
<route-receipt-image-settings pictures="{{json_encode($pictures)}}"></route-receipt-image-settings>
@endsection
