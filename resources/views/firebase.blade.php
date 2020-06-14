@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
@endphp
@section('content')
    <div id="container">
        @if(session('resent'))
            <div class="alert alert-info py-5"> email activation sent success please check your inbox </div>
        @endif
        <h3 class="text-center py-5">Your Account need to Active </h3>
        <div class="text-center" >we allredy send email activation to your email address </div>
        <div class="text-center py-3">
            <a href="{{route('verification.resend')}}"class="text-center btn btn-primary">resend email</a>
        </div>
    </div>

    @endsection
