@extends('layouts.app')

@section('content')

<main class="form-signin w-50 m-auto">

    <h2>Профиль</h2>
    <form method="POST" action="{{ route("edit_user") }}">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">Имя</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="password_old" class="col-md-4 col-form-label text-md-end">Старый пароль</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password_old" id="password_old">
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
