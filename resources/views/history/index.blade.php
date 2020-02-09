@extends('layouts.default')

@section('htmlheader_title')
История изменений
@endsection


@section('content')
<history-table dates="{{json_encode($dates)}}"></history-table>
@endsection