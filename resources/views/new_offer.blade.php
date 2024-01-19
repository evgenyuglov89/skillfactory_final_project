@extends('layouts.app')

@section('content')
    <main class="form-signin w-50 m-auto">
        <h1 class="h3 mb-3 fw-normal">Новый offer</h1>

        <form method="POST" action="{{ route("create_offer") }}">
            @csrf
            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">Название</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
            <div class="row mb-3">
                <label for="theme" class="col-md-4 col-form-label text-md-end">Тема</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="theme" name="theme">
                </div>
            </div>
            <div class="row mb-3">
                <label for="url" class="col-md-4 col-form-label text-md-end">URL</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="url" id="url">
                </div>
            </div>
            <div class="row mb-3">
                <label for="cost" class="col-md-4 col-form-label text-md-end">Стоимость перехода</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="cost" id="cost">
                </div>
            </div>
            <div class="row mb-3">
                <label for="status" class="col-md-4 col-form-label text-md-end">Статус</label>
                <div class="col-md-6">
                    <select name="status" class="form-control" id="status">
                        <option>Активный</option>
                        <option>Неактивный</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary">
                    Создать
                </button>
            </div>
        </form>
    </main>
@endsection
