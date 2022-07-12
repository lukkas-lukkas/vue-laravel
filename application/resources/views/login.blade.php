@extends('layouts.basic')

@section('content')
    <login-component csrf_token="{{ @csrf_token() }}"></login-component>
@endSection
