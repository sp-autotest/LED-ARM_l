@extends('layouts.default')

@section('title', 'Компании')



@section('content')
<company-edit data="{{$company}}" currencies="{{$currencies}}" managers="{{$managers}}"></company-edit>
@endsection
