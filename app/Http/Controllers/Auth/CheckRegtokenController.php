<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Проверка токена доступа к регистрации
 */
class CheckRegtokenController extends Controller
{

    public function index(Request $request)
    {
        $token = $request->token;
        if ($token === '12345') {
            return true;
        }
        return false;
    }
}
