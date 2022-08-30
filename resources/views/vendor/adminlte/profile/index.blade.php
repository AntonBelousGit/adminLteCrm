@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
    <div>
        @php
            dd(auth()->user()->currentAccessToken())
        @endphp
        <x-adminlte-callout>API Token: {{auth()->user()->tokens()->first()->token}}</x-adminlte-callout>

    </div>
@stop
