<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\RedirectLog;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;

class RedirectorController extends Controller
{
    // Фиксация редиректа.
    public function fixRedirect($token)
    {
        $subscription = Subscription::whereToken($token)->first();
        $redirectLog = new RedirectLog;
        $redirectLog->token = $token;
        // Если найдена подписка и она активна.
        if($subscription && $subscription->is_active) {
            $redirectLog->offer_id = $subscription->offer_id;
            $redirectLog->webmaster_id = $subscription->subscriber_id;
            $offer = Offer::find($subscription->offer_id);
            // Если offer найден и он активен, фиксируем успешный редирект.
            if($offer && $offer->is_active) {
                $redirectLog->advertiser_id = $offer->owner;
                $redirectLog->action = "success";
                $redirectLog->save();
                return redirect($offer->url);
            } else {
                $redirectLog->action = "offer_not_found";
                $redirectLog->save();
                Log::info(print_r("Offer не найден или неактивен\n" . $token, true));
                return abort(404);
            }
        } else {
            // Если подписка неактивна.
            if($subscription) {
                $redirectLog->offer_id = $subscription->offer_id;
                $redirectLog->webmaster_id = $subscription->subscriber_id;
                $offer = Offer::find($subscription->offer_id);
                if($offer) {
                    $redirectLog->advertiser_id = $offer->owner;
                }
                $redirectLog->action = "link_inactive";
            } else {
                $redirectLog->action = "link_not_found";
            }
            $redirectLog->save();
            Log::info(print_r("Ссылка не найдена или неактивна\n" . $token, true));
            return abort(404);
        }
    }
}
