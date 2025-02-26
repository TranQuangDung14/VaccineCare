<?php

namespace App\Http\Controllers\SecurityCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SecurityCodeController extends Controller
{
    //generate security code
    public function index(){
        $codeVerifier = Str::random(43);
        $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
        return view('Security_Code.security_code',compact('codeVerifier','codeChallenge'));
    }
}
