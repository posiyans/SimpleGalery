<?php

namespace  App\Modules\Gallery\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Gallery\Classes\UpdateGalleryClass;
use App\Modules\Gallery\Repositories\GetGalleryByIdRepository;
use App\Modules\Gallery\Validators\UpdateGalleryValidator;


class UpdateGalleryController extends Controller
{

    public function index($id, UpdateGalleryValidator $request)
    {
        try {
            $gallery = (new GetGalleryByIdRepository($id))->run();
            $result = (new UpdateGalleryClass($gallery))->update($request->all())->run();
            return $result;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

}
