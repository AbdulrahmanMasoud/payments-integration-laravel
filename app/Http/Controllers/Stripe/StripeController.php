<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
// use Stripe\Stripe;
use Stripe\Stripe;
use Stripe\Charge;


class StripeController extends Controller
{
    public function handlePost(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET')); 
        try{
            $charge = Charge::create(array(
                "amount" => 120 * 100,
                'currency'=>'USD',
                'source' =>'tok_mastercard',
                'description'=>'test charge',
                "metadata" => ["order_id" => "10"]

            ));
            // dd($charge);
           session()->put('success', 'Payment successfully made.');
            return back();
        }catch(\Exception $e){
            return $e->getMessage();
        }

    }
}
