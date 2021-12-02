<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;

class SmsController extends Controller
{
    public function sendMessage($data){
      try {
        $message = Nexmo::message()->send([
          'to'   => $data['to'],
          'from' => '639663126435',
          'text' => $data['body'] . ' Thank you and have a great day!'          
        ]);        
       }catch (\Exception $e) {
        echo $e->getMessage();
       }
    }
}