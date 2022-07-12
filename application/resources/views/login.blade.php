@extends('layouts.basic')

@section('basic-content')
    <login-component csrf_token="{{ @csrf_token() }}"></login-component>
@endSection
