<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function getToken()
    {
        return json_encode(csrf_token()); 
    }
}
