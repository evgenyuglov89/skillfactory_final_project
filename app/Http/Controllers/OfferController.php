<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateOfferRequest;
use App\Http\Requests\UpdateOfferRequest;

class OfferController extends Controller
{
    // Создание нового offer-а.
    public function createOffer(CreateOfferRequest $request)
    {
        $validated = $request->validated();
        $offer = new Offer;
        $offer->name = $validated['name'];
        $offer->theme = $validated['theme'];
        $offer->url = $validated['url'];
        $offer->cost = $validated['cost'];
        $offer->is_active = $validated['status'] == "Активный" ? 1 : 0;
        $offer->owner = Auth::id();
        $offer->save();

        return redirect()->route('offers_list');
    }

    // Обновление данных offer-а.
    public function updateOffer(UpdateOfferRequest $request)
    {
        $validated = $request->validated();
        $offer = Offer::find($validated['id']);
        $offer->name = $validated['name'];
        $offer->theme = $validated['theme'];
        $offer->url = $validated['url'];
        $offer->cost = $validated['cost'];
        $offer->is_active = $validated['status'] == "Активный" ? 1 : 0;
        $offer->save();
        return redirect()->route('offers_list');
    }

    // Формирование списка активных offer-ов для веб-мастера.
    public function getOffersWebmaster()
    {
        $offers = DB::table('offers as o')->select('o.id', 'o.name', 'o.theme', 'o.cost', 'u.name as owner', 'o.url', 'o.created_at')
        ->leftJoin('users as u', 'o.owner', '=', 'u.id')
        ->where('o.is_active', 1)->get();
        $subscriptions = Subscription::whereSubscriberId(Auth::id())->whereIsActive(1)->get();
        foreach ($offers as $offer) {
            // Формируем input.
            $offer->actions = '<label class="switch">
            <input type="checkbox" class="switch__input" value="' . $offer->id . '"';

            // Определяем offer-ы на которые подписан веб-мастер.
            $filtered = $subscriptions->filter(function ($value) use ($offer) {
                return $value->offer_id == $offer->id;
            })->first();

            if(isset($filtered)) {
                $offer->link = $filtered->link;
                $offer->actions .= ' checked';
            }

            $offer->actions .= '/>
                <span class="switch__slider"></span>
            </label>';
        }
        $js = json_encode($offers);
        return $js;
    }

     // Формирование списка созданных offer-ов для рекламодателя.
    public function getOffersAdvertiser()
    {
        $offers = DB::table('offers as o')->select('o.id', 'o.name', 'o.theme', 'o.cost', 'o.is_active', 'o.url', 'o.subscribers', 'o.created_at')
        ->whereOwner(Auth::id())->get();
        foreach ($offers as $offer) {
            $offer->changed_user = '<button type="button" class="btn btn-info">
            <a href="/edit_offer/' . $offer->id . '" class="nav-link px-2">Редактировать</a>
            </button>';

            // Формируем input.
            $offer->changed_status = '<label class="switch">
            <input type="checkbox" class="switch__input" value="' . $offer->id . '"';
            // Определяем статус offer-а.
            if($offer->is_active) {
                $offer->status = "Активен";
                $offer->changed_status .= ' checked';
            } else {
                $offer->status = "Неактивен";
            }
            // Кол-во подписчиков на offer.
            $offer->subscribers_number = $offer->subscribers ? $offer->subscribers : 0;
            $offer->changed_status .= '/>
                <span class="switch__slider"></span>
            </label>';
        }
        $js = json_encode($offers);
        return $js;
    }

    // Изменение статуса offer-а.
    public function changeStatus($action, $id)
    {
        $user = Offer::find($id);
        if($action == "activate") {
            $user->is_active = 1;
        } else {
            $user->is_active = 0;
        }
        $user->save();

        return "ok";
    }

    // Подписка на offer.
    public function subscribe($id)
    {
        $subscription = Subscription::whereOfferId($id)->whereSubscriberId(Auth::id())->whereIsActive(1)->first();
        if(!$subscription) {
            $offer = Offer::find($id);
            // Если подписка идёт на offer, который стал неактивен, будет обновлена таблица и offer пропадёт из неё.
            if(!$offer->is_active) {
                return "bad_offer";
            }
            $subscription = new Subscription;
            $subscription->offer_id = $id;
            $subscription->subscriber_id = Auth::id();
            $subscription->token = md5(time());
            $subscription->link = request()->getSchemeAndHttpHost() . "/api/SF-AdTech/redirect/" . $subscription->token;
            $subscription->save();
            // Увеличиваем кол-во подписчиков на offer.
            if($offer->subscribers) {
                $offer->subscribers++;
            } else {
                $offer->subscribers = 1;
            }
            $offer->save();
        }
        return "ok";
    }

    // Отписка от offer-а.
    public function unsubscribe($id)
    {
        $subscription = Subscription::whereOfferId($id)->whereSubscriberId(Auth::id())->whereIsActive(1)->first();
        if($subscription) {
            $subscription->is_active = 0;
            $subscription->save();
            $offer = Offer::find($id);
            $offer->subscribers--;
            $offer->save();
        }
        return "ok";
    }
}
