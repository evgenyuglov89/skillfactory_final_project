<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Страница авторизации.
Route::get('/', [PageController::class, 'login'])->name('login');
// Страница регистрации.
Route::get('/register', [PageController::class, 'register'])->name('register');
// Авторизация.
Route::post('/sign_in', [AuthController::class, 'signIn'])->name('sign_in');
// Регистрация.
Route::post('/sign_up', [AuthController::class, 'signUp'])->name('sign_up');

Route::middleware(['auth', 'check.user.status'])->group(function() {
    // Главная страница.
    Route::get('/home', [PageController::class, 'home'])->name('home');
    // Страница редактирования профиля.
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    // Страница просмотра списка пользователей(доступна админам).
    Route::get('/show_users', [PageController::class, 'showUsers'])->name('show_users');
    // Страница создания нового пользователя(доступна админам).
    Route::get('/new_user', [PageController::class, 'newUser'])->name('new_user');
    // Страница редактирования информации пользователя(доступна админам).
    Route::get('/edit_user/{id}', [PageController::class, 'editUser'])->name('edit_user_view');
    // Страница просмотра списка offer-ов(доступна рекламодателям).
    Route::get('/offers_list', [PageController::class, 'offersList'])->name('offers_list');
    // Страница создания нового offer-а(доступна рекламодателям).
    Route::get('/new_offer', [PageController::class, 'newOffer'])->name('new_offer');
    // Страница редактирования offer-а(доступна рекламодателям).
    Route::get('/edit_offer/{id}', [PageController::class, 'editOffer'])->name('edit_offer_view');
    // Страница просмотра активных offer-ов(доступна веб-мастерам).
    Route::get('/show_active_offer', [PageController::class, 'showActiveOffer'])->name('show_active_offer');
    // Страница статистики по успешным переходам по ссылкам(доступна админам).)
    Route::get('/show_admin_statistics', [PageController::class, 'showAdminStatistics'])->name('show_admin_statistics');
    // Страница статистики по расходам(доступна рекламодателям).
    Route::get('/show_advertiser_statistics', [PageController::class, 'showAdvertiserStatistics'])->name('show_advertiser_statistics');
    // Страница статистики по доходу(доступна вем-мастерам).
    Route::get('/show_webmaster_statistics', [PageController::class, 'showWebmasterStatistics'])->name('show_webmaster_statistics');

    // Получение списка пользователей.
    Route::get('/get_users', [UserController::class, 'getUsers'])->name('get_users');
    // Изменение статуса пользователя.
    Route::get('/change_user_status/{action}/{id}', [UserController::class, 'changeStatus'])->name('change_user_status');
    // Редактирование пользователя.
    Route::post('/edit_user', [UserController::class, 'editUser'])->name('edit_user');
    // Создание пользователя.
    Route::post('/create_user', [UserController::class, 'createUser'])->name('create_user');
    // Обновление информации пользователя.
    Route::post('/update_user', [UserController::class, 'updateUser'])->name('update_user');

    // Получение списка активных offer-ов.
    Route::get('/get_offers_webmaster', [OfferController::class, 'getOffersWebmaster'])->name('get_offers_webmaster');
    // Получение списка созданных offer-ов.
    Route::get('/get_offers_advertiser', [OfferController::class, 'getOffersAdvertiser'])->name('get_offers_advertiser');
    // Изменение статуса offer-а.
    Route::get('/change_offer_status/{action}/{id}', [OfferController::class, 'changeStatus'])->name('change_offer_status');
    // Создание offer-а.
    Route::post('/create_offer', [OfferController::class, 'createOffer'])->name('create_offer');
    // Обновление информации offer-а.
    Route::post('/update_offer', [OfferController::class, 'updateOffer'])->name('update_offer');
    // Отписаться от offer-а.
    Route::get('/unsubscribe/{id}', [OfferController::class, 'unsubscribe'])->name('unsubscribe');
    // Подписаться на offer.
    Route::get('/subscribe/{id}', [OfferController::class, 'subscribe'])->name('subscribe');

    // Страница статистики системы.
    Route::get('/get_admin_statistics/{action}', [StatisticsController::class, 'getAdminStatistics'])->name('get_admin_statistics');
    // Получение информации о системе.
    Route::get('/get_system_profit', [StatisticsController::class, 'getSystemProfit'])->name('get_system_profit');
    // Получение статистики по ссылкам для рекламодателя.
    Route::get('/get_advertiser_statistics/{period}', [StatisticsController::class, 'getAdvertiserStatistics'])->name('get_advertiser_statistics');
    // Получение статистики по ссылкам для веб-мастера.
    Route::get('/get_webmaster_statistics/{period}', [StatisticsController::class, 'getWebmasterStatistics'])->name('get_webmaster_statistics');

    // Выход из системы.
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

