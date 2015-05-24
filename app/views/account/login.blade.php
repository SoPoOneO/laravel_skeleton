@extends('layouts.master')

@section('content')

{{ BootForm::open() }}

    {{ BootForm::text('Email', 'email') }}

    {{ BootForm::password('Password', 'password') }}

    {{ BootForm::submit('Login') }}

{{ BootForm::close() }}

@stop