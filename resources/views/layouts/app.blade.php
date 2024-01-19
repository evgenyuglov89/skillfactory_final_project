<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SF-AdTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.2/dist/bootstrap-table.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="row mb-3">
                    <div class="alert alert-danger" role="alert">
                        {{$error}}
                    </div>
                </div>
            @endforeach
        @endif

        @auth
            <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
                <div class="col-md-3 mb-2 mb-md-0">
                    <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">SF-AdTech</a>
                </div>
                <div>
                    {{Auth::user()->name}}(
                        @if (Auth::user()->role == 0)
                            Администратор
                        @elseif (Auth::user()->role == 1)
                            Рекламодатель
                        @else
                            Веб-мастер
                        @endif
                    )
                </div>

                <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="{{ route("home") }}" class="nav-link px-2">Главная</a></li>

                    @if (Auth::user()->role == 0)
                        <li><a href="{{ route("show_users") }}" class="nav-link px-2">Пользователи</a></li>
                        <li><a href="{{ route("get_system_profit")}}" class="nav-link px-2">О системе</a></li>
                        <li><a href="{{ route("show_admin_statistics")}}" class="nav-link px-2">Статистика по ссылкам</a></li>
                    @endif
                    @if (Auth::user()->role == 1)
                        <li><a href="{{ route("offers_list") }}" class="nav-link px-2">Список offer-ов</a></li>
                        <li><a href="{{ route("show_advertiser_statistics")}}" class="nav-link px-2">Статистика</a></li>
                    @endif
                    @if (Auth::user()->role == 2)
                        <li><a href="{{ route("show_active_offer") }}" class="nav-link px-2">Список offer-ов</a></li>
                        <li><a href="{{ route("show_webmaster_statistics")}}" class="nav-link px-2">Статистика</a></li>
                    @endif
                </ul>

                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-outline-primary me-2" ><a href="{{ route("profile") }}" class="nav-link px-2">Профиль</a></button>
                    <button type="button" class="btn btn-primary"><a href="{{ route("logout") }}" class="nav-link px-2">Выход</a></button>
                </div>
            </header>

            @yield('content')
        @endauth

        @guest
            @yield('auth')
        @endguest

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.2/dist/bootstrap-table.min.js"></script>
    @yield('js')

</body>
</html>
