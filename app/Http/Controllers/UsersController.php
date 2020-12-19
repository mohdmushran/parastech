<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller {

    public function dashboard() {
        $user = Auth::user();
        $stripeCustomer = $user->createOrGetStripeCustomer();
        return view('dashboard', [
            'intent' => $user->createSetupIntent()
        ]);
    }

    public function subscribe(Request $request, $id=null) {
        $user = Auth::user();
        $user->updateDefaultPaymentMethod($id);
        $info = $user->newSubscription(env('APP_SUBSCRIPTION_NAME'), env('STRIPE_PLAN_ID'))->create($id);
        return redirect()->route('dashboard');
    }

}
