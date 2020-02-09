@extends('layouts.default')

@section('title', 'Сотрудники')

@section('content')
<admin-user-edit userar="{{json_encode($usered)}}"></admin-user-edit>
@endsection
