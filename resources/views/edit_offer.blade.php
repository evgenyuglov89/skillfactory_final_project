@extends('layouts.app')

@section('content')

<main class="form-signin w-50 m-auto">

    <h2>Редактирование offer-а</h2>
    <form method="POST" action="{{ route("update_offer") }}">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">Название</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" value="{{$offer->name}}">
            </div>
        </div>
        <input type="text" class="form-control" id="id" name="id" value="{{$offer->id}}" hidden>
        <div class="row mb-3">
            <label for="theme" class="col-md-4 col-form-label text-md-end">Тема</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="theme" name="theme" value="{{$offer->theme}}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="cost" class="col-md-4 col-form-label text-md-end">Стоимость перехода</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="cost" name="cost" value="{{$offer->cost}}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="url" class="col-md-4 col-form-label text-md-end">URL</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="url" name="url" value="{{$offer->url}}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="status" class="col-md-4 col-form-label text-md-end">Статус</label>
            <div class="col-md-6">
                <select name="status" class="form-control" id="status">
                    <option @if ($offer->is_active == 1) selected @endif>Активный</option>
                    <option @if ($offer->is_active ==0) selected @endif>Неактивный</option>
                </select>
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
