<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;
use Sample\CaptureIntentExamples\CreateOrder;

class PaypalController extends Controller
{
   public $clientId = "AS2mrMo96FfbXBur0DgZhxt4_rrE0koVNQq4m6xLIcH7C-k1XmOdmVDLwrpVPPp3hwhOlSzqaqMt_ERg";
   public   $clientSecret = "EL8Wg0SdfHrItnOvhVKp9sw_hVlDqvLv9IfOg-Zn7AcVi2o1RHQ5kTuKUMVmXAsL2Y0cfSK2P9xS6K2q";

   
    public function __construct()
    {
        
        
      $environment = new SandboxEnvironment($this->clientId, $this->clientSecret);
      $client = new PayPalHttpClient($environment);
        $request = new OrdersCreateRequest(1);
        $request->prefer('return=representation');
       
        $request->body = [
                     "intent" => "CAPTURE",
                     "purchase_units" => [[
                         'reference_id' => 'PUHF',
                         'description' => 'Sporting Goods',
                         'custom_id' => 'CUST-HighFashions',
                         'soft_descriptor' => 'HighFashions',
                         "amount" => [
                            "currency_code" => "USD",
                             "value" => "100.00",
                             
                         ]
                     ]],
                     "application_context" => [
                          "cancel_url" => route('paypal.cancel'),
                          "return_url" => route('paypal.return'),
                          
                     ] 
                 ];
                 
                
                 
                // GetOrder::getOrder($createdOrder->id);
            $response = $client->execute($request);
            // dd($response);
    //   return redirect($response->result->links[1]->href);
      return redirect('https://www.sandbox.paypal.com/checkoutnow?token='.$response->result->id);
        
    }
public function capturing(){

}
    public function canceled(){
        return 'Canceld';
    }
    public function returned(){
    $environment = new SandboxEnvironment($this->clientId, $this->clientSecret);
      $client = new PayPalHttpClient($environment);
    $request = new OrdersCaptureRequest('APPROVED-ORDER-ID');
    $request->prefer('return=representation');
    $response = $client->execute($request);
    dd($response);
        try {
        // Call API with your client and get a response for your call
            $response = $client->execute($request);

        // If call returns body in response, you can get the deserialized version from the result attribute of the response
            print_r($response);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }


       
        
    }
}
