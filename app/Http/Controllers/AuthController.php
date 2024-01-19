<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function signIn(SignInRequest $request)
    {
        $validated = $request->validated();
        $user = User::whereEmail($validated['email'])->first();
        if($user && Hash::check($validated['password'], $user->password)) {
            if(!$user->is_active) {
                $error = "Учётная запись была заблокирована. Обратитесь к администратору.";
                return view('login', ['error' => $error]);
            }
            if(isset($validated['remember-me'])) {
                Auth::loginUsingId($user->id, true);
            } else {
                Auth::loginUsingId($user->id);
            }
            return redirect()->route('home');
        } else {
            $error = "Неправильная почта или пароль.";
            return view('login', ['error' => $error]);
        }
    }
    public function signUp(SignUpRequest $request)
    {
        $validated = $request->validated();
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role = $validated['role'] == "Рекламодатель" ? 1 : 2;
        $user->save();
        return redirect()->route('login');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
