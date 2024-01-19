@extends('layouts.app')

@section('auth')
    <main class="form-signin w-50 m-auto">
        <h1>SF-AdTech</h1>
        <h1 class="h3 mb-3 fw-normal">Пожалуйста авторизуйтесь</h1>
        @if (isset($error))
        <div class="row mb-3">
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        </div>
        @endif
        <form method="POST" action="{{ route("sign_in") }}">
            @csrf
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                <label for="email">Почта</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="password">Пароль</label>
            </div>
            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="true" name="remember-me" id="remember-me">
                <label class="form-check-label" for="remember-me">
                    Запомнить меня
                </label>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary">
                    Войти
                </button>
                <a href="{{ route("register") }}" class="btn btn-link">
                    Нет аккаунта
                </a>
            </div>

        </form>
    </main>
@endsection
