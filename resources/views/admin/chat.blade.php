@extends('layouts.default')

@section('htmlheader_title')
Чат
@endsection


@section('content')
 <chat-build sender="{{Auth::user()->email}}"></chat-build>
@endsection
