<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('register');
    }
    public function home()
    {
        return view('home');
    }
    public function profile()
    {
        $user = User::find(Auth::id());
        return view('profile', ['user' => $user]);
    }
    public function showUsers()
    {
        return view('show_users');
    }
    public function newUser()
    {
        return view('new_user');
    }
    public function editUser($id)
    {
        $user = User::find($id);
        return view('edit_user', ['user' => $user]);
    }
    public function offersList()
    {
        return view('offers_list');
    }
    public function newOffer()
    {
        return view('new_offer');
    }
    public function editOffer($id)
    {
        $offer = Offer::find($id);
        return view('edit_offer', ['offer' => $offer]);
    }
    public function showActiveOffer()
    {
        return view('show_active_offers');
    }
    public function showAdminStatistics()
    {
        return view('show_admin_statistics');
    }
    public function showAdvertiserStatistics()
    {
        return view('show_advertiser_statistics');
    }
    public function showWebmasterStatistics()
    {
        return view('show_webmaster_statistics');
    }
}
