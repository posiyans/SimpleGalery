<?php

namespace App\Http\Controllers\Media\Folder;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Media\Folder\FolderRepository;
use Illuminate\Http\Request;

class GetFolderListController extends Controller
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
        $data = (new FolderRepository())->getList();
        return $data;
    }

}
