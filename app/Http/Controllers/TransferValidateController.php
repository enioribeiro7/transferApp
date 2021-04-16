<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransferValidateController extends Controller
{
    public function __construct()
    {
        $this->url_authorization = env('URL_AUTHORIZATION');
    }

    public function getAuthorization(){
        
        $response = Http::get($this->url_authorization);
        
        return $response->status();
    }
}
