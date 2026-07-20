<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;

class Helper
{
    // if (!function_exists('isProductInCart')) {
    //     function isProductInCart($productId) {
    //         $cart = Session::get('cart', []);
    //         return isset($cart[$productId]);
    //     }
    // }

    static function sendSMS($message, $template_id, $mobile)
    {
        $url = "http://139.99.131.165/api/v2/SendSMS";
        $senderId = 'SEYONS';
        $ApiKey = 'xjhJ1Lc8S+45+WcHaM/jHHVhNVyhXM761VUb5SaNf0E=';
        $ClientId = '47aa5f44-a0fe-4783-8e24-3376c2bee2c9';
        if($senderId && $ApiKey && $ClientId){
            $params = [
                "SenderId" => $senderId,
                "Is_Unicode" => "false",
                "Is_Flash" => "false",
                "IsRegisteredForDelivery" => "false",
                "DataCoding" => 0,
                "Message" => $message,
                "MobileNumbers" => $mobile,
                "TemplateId" => $template_id,
                "ApiKey" => $ApiKey,
                "ClientId" => $ClientId,
            ];
        
            $response = Http::withHeaders([
                "accept" => "text/plain"
            ])->get($url, $params);

            $data = json_decode($response->body(), true);

            if (isset($data['ErrorCode']) && $data['ErrorCode'] == 0) {
                return true;
            }
            return false;
        }else{
            return false;
        }
    }
}