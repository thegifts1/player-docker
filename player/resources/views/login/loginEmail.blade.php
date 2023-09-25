@extends('layouts.base')

@section('title', 'Login')

@section('content')
    @if ($errors->any())
        {{ $errors }}
    @endif

    <section class="container">
        <div class="login">
            <h1>{{ __('Login to your account') }}</h1>
            <form method="POST" action="">
                @csrf
                <p><input type="text" name="email" placeholder="{{ __('Email') }}"></p>
                <p class="submit"><input type="submit" name="commit" value="{{ __('Login') }}"></p>
            </form>
        </div>
    </section>
@endsection
