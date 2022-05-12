<?php

namespace App\Http\Controllers\Media\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Media\MediaFileModel;
use App\Models\User;
use App\Modules\Media\Classes\PreviewMediaClass;
use App\Modules\Media\Video\Classes\GenerateVideoScreenshots;
use App\Modules\Storage\Classes\StorageFileClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GetPreviewForGalleryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $gallery_id = $request->id;
        $image = MediaFileModel::where('gallery_id', $gallery_id)->get()->random(1)->first();
        if ($image) {
            $path = StorageFileClass::getCachePathForHash($image->hash);
            if (!file_exists($path)) {
                $fullPath = Storage::path($image->path);
                $path = (new PreviewMediaClass($fullPath))->getPath();
            }
            return response()->download($path);
        }
        return response()->download(__DIR__ . '/no-find.jpg');
    }

}
