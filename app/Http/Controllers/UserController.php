<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Carbon\Carbon;

class UserController extends Controller
{
    // Получение информации о пользователях.
    public function getUsers()
    {
        $users = User::all();
        foreach ($users as $user) {
            if($user->role == 1) {
                $user->role = "Рекламодатель";
            } else if($user->role == 2) {
                $user->role = "Веб-мастер";
            } else {
                $user->role = "Админ";
            }
            $user->status = $user->is_active ? "Активен" : "Неактивен";
            // Формирование кнопки редактирования.
            $user->changed_user = '<button type="button" class="btn btn-info">
            <a href="/edit_user/' . $user->id . '" class="nav-link px-2">Редактировать</a>
            </button>';
            // Формирование input.
            $user->changed_status = '<label class="switch">
            <input type="checkbox" class="switch__input" value="' . $user->id . '"';
            if($user->is_active) {
                $user->changed_status .= ' checked';
            }
            $user->changed_status .= '/>
                <span class="switch__slider"></span>
            </label>';
        }
        $js = json_encode($users);
        return $js;
    }

    // Изменение статуса пользователя.
    public function changeStatus($action, $id)
    {
        $user = User::find($id);
        if($action == "activate") {
            $user->is_active = 1;
        } else {
            $user->is_active = 0;
        }
        $user->save();

        return "ok";
    }
    // Редактирование информации в профиле.
    public function editUser(EditUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::find(Auth::id());
        $user->name = $validated['name'];
        if(isset($validated['password_new'])) {
            $user->password = Hash::make($validated['password_new']);
        }
        $user->save();
        return redirect()->route('home');
    }

    // Создание нового пользователя.
    public function createUser(CreateUserRequest $request)
    {
        $validated = $request->validated();
        $user = new User;
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $type = 0;
        if($validated['role'] == "Рекламодатель") {
            $type = 1;
        } else if($validated['role'] == "Веб-мастер") {
            $type = 2;
        }
        $user->role = $type;
        $user->save();
        return redirect()->route('show_users');
    }
    // Редактирование пользователей админом.
    public function updateUser(UpdateUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::find($validated['id']);
        $user->name = $validated['name'];
        if($validated['role'] == "Рекламодатель") {
            $user->role = 1;
        } else if($validated['role'] == "Веб-мастер") {
            $user->role = 2;
        } else {
            $user->role = 0;
        }
        $user->is_active = $validated['status'] == "Активен" ? 1 : 0;
        if(isset($validated['password_new'])) {
            $user->password = Hash::make($validated['password_new']);
        }
        $user->save();
        return redirect()->route('show_users');
    }
}
