@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css')}}">
@endsection

@section('content')
<div class="register-form">
    <div class="register-form__header">
        <h2 class="register-form__header--logo">Login</h2>
    </div>
    <div class="register-form__content">
        <form class="login" method="POST" action="/login">
            @csrf
            <div class="register-form__item">
                <label><i class="fa-solid fa-envelope fa-xl" style="color: #4B4B4B;"></i></label>
                <input class="register-form__input" type="text" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
            </div>
            @if ($errors->has('email'))
            @foreach($errors->get('email') as $message)
            <p class="register-form__error-message">
                {{ $message }}
            </p>
            @endforeach
            @endif
            <div class="register-form__item">
                <label><i class="fa-solid fa-key fa-xl" style="color: #4B4B4B;"></i></label>
                <input class="register-form__input" type="password" name="password" id="password" placeholder="Password" value="{{ old('password') }}">
            </div>
            @if ($errors->has('password'))
            @foreach($errors->get('password') as $message)
            <p class="register-form__error-message">
                {{ $message }}
            </p>
            @endforeach
            @endif
            <div class="register-form__item"><input class="register-form--button" type="submit" value="ログイン"></div>
        </form>
    </div>
    @endsection