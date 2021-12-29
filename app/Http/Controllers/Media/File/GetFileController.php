<?php

namespace App\Http\Controllers\Media\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetFileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get(Request $request)
    {
        $file = $request->file;
        $dir    = '/home/posiyans/Изображения/DCIM/101MSDCF';
        $pathToFile = $dir . '/'. $file;
        return response()->download($pathToFile);
    }
}
