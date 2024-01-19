@extends('layouts.app')

@section('auth')
    <main class="form-signin w-50 m-auto">
        <h1>SF-AdTech</h1>
        <h1 class="h3 mb-3 fw-normal">Пожалуйста зарегистрируйтесь</h1>

        <form method="POST" action="{{ route("sign_up") }}">
            @csrf
            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">Имя</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">Почта</label>
                <div class="col-md-6">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">Пароль</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>
            <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Подтвердите пароль</label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="role" class="col-md-4 col-form-label text-md-end">Роль</label>
                <div class="col-md-6">
                    <select name="role" class="form-control" id="role">
                        <option>Рекламодатель</option>
                        <option>Веб-мастер</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary">
                    Зарегистрироваться
                </button>
                <a href="{{ route("login") }}" class="btn btn-link">
                    Уже есть аккаунт
                </a>
            </div>
        </form>
    </main>
@endsection
