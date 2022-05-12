<?php

namespace  App\Modules\Gallery\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Gallery\Repositories\GetChildrenTreeForGalleryRepository;
use App\Modules\Gallery\Repositories\GetPrimaryGalleriesForUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetTreeGalleryController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $primary = (new GetPrimaryGalleriesForUserRepository($user))->run();
        foreach ($primary as $item) {
            (new GetChildrenTreeForGalleryRepository($item))->run();
        }
        return $primary;
    }

}
