@extends('layouts.app')

@section('content')

<main class="form-signin w-50 m-auto">

    <h2>Редактирование пользователя</h2>
    <form method="POST" action="{{ route("update_user") }}">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">Имя</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
            </div>
        </div>
        <input type="text" class="form-control" id="id" name="id" value="{{$user->id}}" hidden>
        <div class="row mb-3">
            <label for="role" class="col-md-4 col-form-label text-md-end">Роль</label>
            <div class="col-md-6">
                <select name="role" class="form-control" id="role">
                    <option @if ($user->role == 1) selected @endif>Рекламодатель</option>
                    <option @if ($user->role == 2) selected @endif>Веб-мастер</option>
                    <option @if ($user->role == 0) selected @endif>Администратор</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="status" class="col-md-4 col-form-label text-md-end">Статус</label>
            <div class="col-md-6">
                <select name="status" class="form-control" id="status">
                    <option @if ($user->is_active == 1) selected @endif>Активен</option>
                    <option @if ($user->is_active == 0) selected @endif>Неактивен</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="password_new" class="col-md-4 col-form-label text-md-end">Новый пароль</label>
            <div class="col-md-6">
                <input id="password_new" type="password" class="form-control" name="password_new">
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-primary">
                Сохранить
            </button>
        </div>
    </form>
</main>

@endsection
