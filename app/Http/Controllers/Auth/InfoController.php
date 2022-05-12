<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfoController extends Controller
{

    public function info(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            Auth::guard( 'web')->login($user);
            return $user;
        }
        return ['name' => 'Гость', 'role' => 'guest'];
    }
}
