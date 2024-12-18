<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// if (!function_exists('info_user')) {
//     function info_user()
//     {
//         dd('sssss');
//         $user = Auth::user();
//         dd($user);
//         return $user;
//     }
// }

if (!function_exists('info_user')) {
    function info_user()
    {
        $user = Auth::user();
        $user = [
            'name' => $user->name,
            'email' => $user->email,
        ];
        return $user;
    }
}

