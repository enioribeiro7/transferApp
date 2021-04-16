<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationTransferController extends Controller
{
    public function __construct()
    {
        $this->url_authorization = env('URL_AUTHORIZATION');
    }

    public function sentNotification(){
        
        $response = Http::get($this->url_authorization);
        
        return $response->status();
    }
}
