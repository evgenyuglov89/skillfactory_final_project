@extends('layouts.app')

@section('content')

<h1>Добро пожаловать {{Auth::user()->name}} в приложение SF-AdTech </h1>
<p>Приложение SF-AdTech — это трекер трафика, созданный для организации взаимодействия компаний (рекламодателей), которые хотят привлечь к себе на сайт посетителей и покупателей (клиентов), и владельцев сайтов (веб-мастеров), на которые люди приходят, например, чтобы почитать новости или пообщаться на форуме</p>

<p>Вам доступны следующие опции:</p>
<ul class="list-group">

@if (Auth::user()->role == 0)
        <li class="list-group-item">Просмотр списка пользователей и редактирование их данных</li>
        <li class="list-group-item">Создание нового пользователя</li>
        <li class="list-group-item">Просмотр информации о системе</li>
        <li class="list-group-item">Просмотр информации по ссылкам</li>
@elseif(Auth::user()->role == 1)
    <li class="list-group-item">Просмотр списка offer-ов и редактирование их данных</li>
    <li class="list-group-item">Создание нового offer-а</li>
    <li class="list-group-item">Просмотр статистики по offer-ам</li>
@else
    <li class="list-group-item">Просмотр списка активных offer-ов и возможность подписаться на них</li>
    <li class="list-group-item">Просмотр статистики по offer-ам</li>
@endif
</ul>

@endsection
