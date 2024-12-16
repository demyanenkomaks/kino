@extends('kino::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('kino.name') !!}</p>
@endsection
