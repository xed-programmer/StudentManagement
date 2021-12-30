<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Nexmo\Laravel\Facade\Nexmo;

class SendSMS{
    
    public static function sendCode($phone)
    {
        try{
            $code = rand(1111, 9999);  
            Nexmo::message()->send([
                'to' => '63'. substr($phone, 1),
                'from' => '639663126435',
                'text' => 'Verify Code: ' . $code
            ]);
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }

        return $code;
    }
    
    public static function sendManySMS($message, $phones)
    {   
        try{
            foreach ($phones as $phone) {
                Nexmo::message()->send([
                    'to' => '63'. substr($phone, 1),
                    'from' => '639663126435',
                    'text' => $message
                ]);   
            }  
        }  catch(\Exception $e){
            Log::error($e->getMessage());
        }      
    }

    public static function sendSMS($message, $phone)
    {   
        try{
            Nexmo::message()->send([
                'to' => '63'. substr($phone, 1),
                'from' => '639663126435',
                'text' => $message
            ]);  
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }            
    }
}