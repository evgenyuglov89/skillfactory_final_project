<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Offer;
use App\Models\RedirectLog;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    // Формирование статистики по ссылкам для админа.
    public function getAdminStatistics($action)
    {
        $offers = Offer::get()->keyBy('id');
        $users = User::get()->keyBy('id');
        // Статистика по выданным ссылкам.
        if($action == 'create_links') {
            $subscriptions = Subscription::all();
            foreach ($subscriptions as $subscription) {
                $subscription->name = $offers[$subscription->offer_id]->name;
                $subscription->advertiser_name = $users[$offers[$subscription->offer_id]->owner]->name;
                $subscription->webmaster_name = $users[$subscription->subscriber_id]->name;
                $subscription->status = $subscription->is_active ? "Активна" : "Неактивна";
            }

            $js = json_encode($subscriptions);
            return $js;
        }
        // Статистика по переходам по ссылкам.
        if($action == 'click_links') {
            $redirectLogs = DB::table('redirect_logs as rl')->select('rl.token', 'rl.action', 'rl.created_at', 'o.name', 's.link')
            ->leftJoin('subscriptions as s', 'rl.token', '=', 's.token')
            ->leftJoin('offers as o', 'rl.offer_id', '=', 'o.id')
            ->get();
            foreach ($redirectLogs as $redirectLog) {
                if($redirectLog->action == 'success') {
                    $redirectLog->status = "Успешно";
                }
                if($redirectLog->action == 'offer_not_found') {
                    $redirectLog->status = "Offer не найден или не активен";
                }
                if($redirectLog->action == 'link_inactive') {
                    $redirectLog->status = "Ссылка не активна";
                }
                if($redirectLog->action == 'link_not_found') {
                    $redirectLog->status = "Ссылка не найдена";
                }
            }
            $js = json_encode($redirectLogs);
            return $js;
        }
    }
    // Формирование статистики о системе.
    public function getSystemProfit()
    {
        $data = new stdClass;
        $users = User::select('role', DB::raw('COUNT(*)'))->groupBy(['role'])->get()->keyBy('role')->toArray();
        // Админов в системе.
        $data->admin_count = $users[0]['count'] ?? 0;
        // Рекламодателей в системе.
        $data->advertiser_count = $users[1]['count'] ?? 0;
        // Веб-мастеров в системе.
        $data->webmaster_count = $users[2]['count'] ?? 0;
        $offers = Offer::select('is_active')->get();
        // Общее кол-во offer-ов.
        $data->offers_count = $offers->count();
        // Кол-во действующих offer-ов.
        $data->offers_active_count = $offers->filter(function ($value) {
            return $value->is_active == 1;
        })->count();
        $subscriptions = Subscription::select('is_active')->get();
        // Общее кол-во сгенерированных ссылок.
        $data->links_count = $subscriptions->count();
        // Кол-во действующих ссылок.
        $data->links_active_count = $subscriptions->filter(function ($value) {
            return $value->is_active == 1;
        })->count();
        $redirectLogs = DB::table('redirect_logs as rl')->select('rl.action', 'rl.offer_id', 'o.cost')
        ->leftJoin('offers as o', 'rl.offer_id', '=', 'o.id')
        ->get();
        // Общее кол-во переходов по ссылкам.
        $data->redirect_count = $redirectLogs->count();
        $redirectSuccess = $redirectLogs->filter(function ($value) {
            return $value->action == "success";
        });
        // Кол-во успешных переходов по ссылкам.
        $data->redirect_success_count = $redirectSuccess->count();
        // Доход системы.
        $data->system_profit = 0;
        foreach ($redirectSuccess as $item) {
            $data->system_profit += 0.2 * $item->cost;
        }

        return view('show_system_profit', ['data' => $data]);
    }

    // Формирование статистики для рекламодателя.
    public function getAdvertiserStatistics($period)
    {
        $offers = Offer::whereOwner(Auth::id())->get();
        if($period == "day") {
            $dates = [now()->startOfDay(), now()->endOfDay()];
        } else if($period == "month") {
            $dates = [now()->startOfMonth(), now()->endOfMonth()];
        } else {
            $dates = [now()->startOfYear(), now()->endOfYear()];
        }

        foreach ($offers as $offer) {
            $redirectCount = RedirectLog::whereOfferId($offer->id)->whereAction('success')->whereBetween('created_at', $dates)->count();
            $offer->redirect_success_count = $redirectCount;
            // Расходы рекламодателя.
            $offer->costs = $redirectCount * $offer->cost;
        }
        $js = json_encode($offers);
        return $js;
    }

    // Формирование статистики для веб-мастера.
    public function getWebmasterStatistics($period)
    {
        $subscriptions = DB::table('subscriptions as s')->select('s.offer_id', 'o.name', 'o.cost')
        ->leftJoin('offers as o', 's.offer_id', '=', 'o.id')
        ->whereSubscriberId(Auth::id())->groupBy(['s.offer_id', 'o.name', 'o.cost'])->get();

        if($period == "day") {
            $dates = [now()->startOfDay(), now()->endOfDay()];
        } else if($period == "month") {
            $dates = [now()->startOfMonth(), now()->endOfMonth()];
        } else {
            $dates = [now()->startOfYear(), now()->endOfYear()];
        }
        $data = [];
        foreach ($subscriptions as $offer) {
            $tmp = new stdClass;
            $tmp->name = $offer->name;
            // Переходы по ссылкам за указанный период.
            $redirectLogs = RedirectLog::whereOfferId($offer->offer_id)->whereWebmasterId(Auth::id())->whereBetween('created_at', $dates)->get();
            $tmp->redirect_count = $redirectLogs->count();
            // Кол-во успешных переходов по ссылкам.
            $redirectSuccess = $redirectLogs->filter(function ($value) {
                return $value->action == "success";
            })->count();
            $tmp->redirect_success_count = $redirectSuccess;
            // Доход веб-мастера.
            $tmp->costs = round(0.8 * $offer->cost * $redirectSuccess, 2);

            $data[] = $tmp;
        }
        $js = json_encode($data);
        return $js;
    }
}
