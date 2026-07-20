<?php

namespace App\Services;

class FcmService
{

    function sendPushNotification($dataArray) { 
    
    
    	$device_token = $dataArray["device_token"];
    	
    		$noficationTitle = $dataArray["notification_title"];
    		$noficationBody = $dataArray["notification_body"];
    		

        $url = ("https://fcm.googleapis.com/fcm/send");
    
    		$token = $device_token;
    		$title = $noficationTitle;
    		$body = $noficationBody;
    		$notification = array('title' =>$title , 'body' => $body);
    
    		$arrayToSend = array('to' => $token, 'notification' => $notification);
    
    		$json = json_encode($arrayToSend);
    		$headers = array();
    		$headers[] = 'Content-Type: application/json';
    		$headers[] = 'Authorization: key=AAAAQcp3xIw:APA91bEyH8fHevTy9y9I7TfK02CzlgRC7uJlAMQEopxBTjpdeo1gbMZACHvXJVv2wtmSe2UjSeSSsnKTYqBEGgxp5265W889IjRqg9JA2h8i2fS0NYcMH5uPow75zm-X4pv51VjpYRwy';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $result = curl_exec($ch);
        //   print_r($result); exit();
    		curl_close($ch);
    
    }
    
 
}