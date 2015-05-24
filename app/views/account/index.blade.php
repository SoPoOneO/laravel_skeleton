@extends('layouts.master')

@section('content')

{{ l($user->toArray()) }}

@stop
