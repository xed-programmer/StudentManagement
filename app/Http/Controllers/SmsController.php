<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;

class SmsController extends Controller
{
    public function sendMessage(){
      try {
        $message = Nexmo::message()->send([
          'to'   => '639663126435',
          'from' => '639510592362',
          'text' => 'SMS NOTIFICATION GOODS NA .'
        ]);
        echo 'sent';
       }catch (\Exception $e) {
        echo $e->getMessage();

       }
    }
}