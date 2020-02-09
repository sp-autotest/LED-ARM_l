@extends('layouts.default')

@section('title', 'Сообщения')



@section('content')
  <chat-build sender="{{Auth::user()->email}}" authuser="{{Auth::user()->id}}"></chat-build>
@endsection
