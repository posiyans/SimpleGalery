<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class InfoController extends Controller
{

    public function info()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return json_encode($user);
        }
        return ['name' => 'Гость', 'role' => 'guest'];
    }
}
