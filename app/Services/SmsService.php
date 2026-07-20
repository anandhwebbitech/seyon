<?php

namespace App\Services;

class SmsService
{
    public function sendSms($phone, $message,$type)
    {
    // if($type == 'register_otp')
    // {
    //     $phone = $phone;
    //     $otp   = $message;
    //     $url ='http://139.99.131.165/api/v2/SendSMS?SenderId=WEBBIT&Message='.$otp.'%20is%20the%20OTP%20.%20Thanks%20for%20Your%20Registration%20with%20Us.%20OTP%20is%20valid%20for%2010%20mins.%20Please%20do%20not%20share%20with%20anyone.%20WEBBITECH&MobileNumbers='.$phone.'&PrincipleEntityId=1701164388774187736&TemplateId=1707164421095374379&ApiKey=4kJGsnWl5CqoieTRKzScV3AaLIzNY573wU8yibjCW9A%3D&ClientId=6807e8ea-12fb-4aae-9442-d0470fd0cc76';
    //  // print_r($url); exit();
    //     $headers = array("Content-Type: application/json");
    
    //     $rest = curl_init();
    //     curl_setopt($rest, CURLOPT_URL, $url);
    //     curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($rest, CURLOPT_RETURNTRANSFER, true);
    
    //     $response = curl_exec($rest);
    //     $jsonResponse = json_decode($response, true);
        
    //     // Check if the response contains the expected success message
    //     if (isset($jsonResponse['Data'][0]['MessageErrorDescription']) && $jsonResponse['Data'][0]['MessageErrorDescription'] === 'Success') {
    //         return true;
    //     } else {
    //         return false;
    //     }

    // }
    
    // else if($type == 'forget_password')
    // {
        
    //     $phone = $phone;
    //     $otp   = $message;
    //     $url ='http://139.99.131.165/api/v2/SendSMS?SenderId=WEBBIT&Message='.$otp.'%20is%20the%20OTP%20.%20OTP%20is%20valid%20for%2010%20mins.%20Please%20do%20not%20share%20with%20anyone.%20WEBBITECH&MobileNumbers='.$phone.'&PrincipleEntityId=1701164388774187736&TemplateId=1707167205644994648&ApiKey=2ee7f96e-3313-479d-a285-36b8d57b0bf4&ClientId=c6a08ee3-b6d4-4578-a683-21b1c7566c0d';
    //     $headers = array("Content-Type: application/json");
    //     $rest = curl_init();
    //     curl_setopt($rest, CURLOPT_URL, $url);
    //     curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($rest, CURLOPT_RETURNTRANSFER, true);
    
    //     $response = curl_exec($rest);
    //     $jsonResponse = json_decode($response, true);
        
    //     // Check if the response contains the expected success message
    //     if (isset($jsonResponse['Data'][0]['MessageErrorDescription']) && $jsonResponse['Data'][0]['MessageErrorDescription'] === 'Success') {
    //         return true;
    //     } else {
    //         return false;
    //     }

    // }
        
        
    return true;
    
    }
}