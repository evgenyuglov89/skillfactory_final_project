<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Запуск проекта.

В папке с проектом в консоли выполняем команду `composer install`. Если после её выполнения не был создан в корне файла `.env`, то в консоли выполняем ещё две команды 

`php -r "copy('.env.example', '.env');"` 

`php artisan key:generate`

Создаём базу данных, в файле `.env` настраиваем к ней подключение.

Для создания таблиц в базе данных запускам команду `php artisan migrate`.

Для заполнения таблиц данными, можно выполнить SQL запросы из файлов, которые лежат в папке `database`

У всех пользователей пароль 123456789

Для запуска проекта выполняем команду `php artisan serve`

## Описание проекта.

>Приложение SF-AdTech — это трекер трафика, созданный для организации взаимодействия компаний (рекламодателей), которые хотят привлечь к себе на сайт посетителей и покупателей (клиентов), и владельцев сайтов (веб-мастеров), на которые люди приходят, например, чтобы почитать новости или пообщаться на форуме.

> В системе предусмотрены три роли пользователей:

1. Администратор (role = 0)
2. Рекламодатель (role = 1)
3. Веб-мастер (role = 2)

Роль "Администратор" не может быть выбрана при создании учётной записи, эту роль может назначить либо другой Администратор, либо изменять в базе данных.

Роли "Рекламодатель" и "Веб-мастер" могут быть выбраны при создании учётной записи.

Администратору доступны следующие опции:

* Создание новых пользователей
* Редактирование данных существующих пользователей
* Смена статуса пользователей
* Просмотр информации о системе
* Просмотр информации по ссылкам

Рекламодателю доступны следующие опции:

* Создание offer-а
* Редактирование существующих, своих, offer-ов
* Смена статуса, своих, offer-ов
* Просмотр статистики по своим offer-админа

Веб-мастеру доступны следующие опции:

* Просмотр списка доступных активных offer-ов
* Возможность подписаться на offer
* Возможность отписаться от offer-а
* Просмотр статистики по переходам по ссылкам

Как только Веб-мастер подписывается на offer, будет сгенерирована ссылка, которую он может использовать у себя на ресурсе. При переходи клиентом по этой ссылке, система-редиректор зафиксирует факт перехода в базе данных и при успешном переходе клиент будет перенаправлен на страницу сайта рекламодателя.
При неуспешном переходе, клиент будет перенаправлен на страницу 404.
