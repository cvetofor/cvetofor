@extends('twill::layouts.errors')

@section('content')
  <p>Внимание! {{ $message }}</p>
  <a href="{{ $link }}">Перейти</a>
@stop
