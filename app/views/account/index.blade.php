@extends('layouts.master')

@section('content')


{{ BootForm::open() }}

    {{ BootForm::text('First Name', 'first_name')->defaultValue($user->first_name) }}

    {{ BootForm::text('Last Name', 'last_name')->defaultValue($user->last_name) }}

    {{ BootForm::text('Phone', 'phone')->defaultValue($user->phone) }}

    {{ BootForm::text('Email', 'email')->defaultValue($user->email) }}

    {{ BootForm::submit('Save') }}

{{ BootForm::close() }}

@stop
