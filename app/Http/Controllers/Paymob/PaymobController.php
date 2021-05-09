<?php

namespace App\Http\Controllers\Paymob;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymobController extends Controller
{
    public function index(){
        return view('paymob');
    }

    public function cURL($url, $json)
    {
        // Create curl resource
        $ch = curl_init($url);

        // Request headers
        $headers = array();
        $headers[] = 'Content-Type: application/json';

        // Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // to return a response 1=true
        curl_setopt($ch, CURLOPT_POST, 1); //TRUE to do a regular HTTP POST.
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json)); // دي الداتا اللي عايز ابعتها
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //An array of HTTP header fields to set, in the format array('Content-type: text/plain', 'Content-length: 100')

        // $output contains the output string
        $output = curl_exec($ch);

        // Close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
    }

 /**
     * Send GET cURL request to paymob servers.
     *
     * @param  string  $url
     * @return array
     */
    protected function GETcURL($url)
    {
        // Create curl resource
        $ch = curl_init($url);

        // Request headers
        $headers = array();
        $headers[] = 'Content-Type: application/json';

        // Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $output contains the output string
        $output = curl_exec($ch);

        // Close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
    }

    public function authPaymob()
    {
        // Request body
        $json = [
            'username' => 'AbdulrahmanMasoud',
            'password' => 'Abdulrahman234@'
        ];

        // Send curl
        $auth = $this->cURL('https://accept.paymobsolutions.com/api/auth/tokens',$json);
        // return $auth;
        // dd($auth->profile->id);
        $token=$auth->token;
        $merchantId = $auth->profile->id;
        return redirect(route('mk.order',['token'=>$token,'id'=>$merchantId]));
    }


     /**
     * Register order to paymob servers
     *
     * @param  string  $token
     * @param  int  $merchant_id
     * @param  int  $amount_cents
     * @param  int  $merchant_order_id
     * @return array
     */
    public function makeOrderPaymob(Request $req)
    {
        $d = [
            [
            "name"=> "ASC1515",
            "amount_cents"=> "500000",
            "description"=> "Smart Watch",
            "quantity"=> "1"
            ],
        [ 
            "name"=> "ERT6565",
            "amount_cents"=> "200000",
            "description"=> "Power Bank",
            "quantity"=> "1"
        ]
        ];
        // Request body
        $json = [
            'merchant_id'            => $req->id,
            'amount_cents'           => 50,
            'merchant_order_id'      => rand(0,1000),
            'currency'               => 'EGP',
           
        ];

        // Send curl
        $order = $this->cURL(
            'https://accept.paymobsolutions.com/api/ecommerce/orders?token='.$req->token,
            $json
        );
        dd($order);
        $token = $req->token;
        $orderId = $order->merchant_order_id;
        return redirect(route('get.payment.key',['token'=>$token,'id'=>$orderId]));
        // return redirect(view('paymob-view',['token'=>$token,'id'=>$orderId]));

        // return $order;
    }
    public function getPaymentKeyPaymob(
        
        $email   = 'null',
        $fname   = 'null',
        $lname   = 'null',
        $phone   = 'null',
        $city    = 'null',
        $country = 'null'
    ) {
        // dd(request('id'));
      // Request body
      $json = [
          'amount_cents' => 50*100,
          'expiration'   => 36000,
          'order_id'     => request('id'),
          "billing_data" => [
              "email"        => $email,
              "first_name"   => $fname,
              "last_name"    => $lname,
              "phone_number" => $phone,
              "city"         => $city,
              "country"      => $country,
              'street'       => 'null',
              'building'     => 'null',
              'floor'        => 'null',
              'apartment'    => 'null'
          ],
          'currency'            => 'EGP',
          'card_integration_id' => config('paymob.integration_id')
      ];

      // Send curl
      $payment_key = $this->cURL(
          'https://accept.paymobsolutions.com/api/acceptance/payment_keys?token='.request('token'),
          $json
      );

      dd( $payment_key);
  }
    
}

