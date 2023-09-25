@extends('layouts.base')

@section('title', 'Login')

@section('content')
    @if ($errors->any())
        {{ $errors }}
    @endif

    <section class="container">
        <div class="login">
            <div class="login_link_div">
                <a class="login_link" href="{{ route('login.loginEmail') }}">Login with email code</a>
            </div>
            <div class="login_link_div">
                <a class="login_link" href="{{ route('login.loginName') }}">Login with your password</a>
            </div>
        </div>
    </section>
@endsection
