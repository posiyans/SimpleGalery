<?php

namespace App\Http\Controllers\Media\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetListController extends Controller
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
        $dir    = '/home/posiyans/Изображения/DCIM/101MSDCF';
        $files = array_diff(scandir($dir), ['..', '.']);
        return array_values($files);
    }
}
