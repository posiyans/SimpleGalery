<?php

namespace App\Http\Controllers\Media\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Media\MediaFileModel;
use App\Modules\Media\Classes\MediaClass;
use App\Modules\Media\Classes\PreviewMediaClass;
use App\Modules\Storage\Classes\StorageFileClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class GetImageListForGalleryController extends Controller
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
    public function index(Request $request)
    {
        $gallery_id = $request->id;
        //Cache::flush();
        $images = MediaFileModel::where('gallery_id', $gallery_id)->orderBy('date')->get();
        foreach ($images as $key => $image) {
            $image->Orientation = 1;
            $image->ratio = 1;
            try {
                $info = Cache::rememberForever('imageInfo_' . $image->hash, function () use ($image) {
                    $fullPath = Storage::path($image->path);
                    $media = MediaClass::getMedia($fullPath, $image->type);
                    $ratio = $media->Ratio(true);
                    $orientation = $media->Orientation();
                    return ['orientation' => $orientation, 'ratio' => $ratio];
                });
                $image->Orientation = $info['orientation'];
                $image->ratio = $info['ratio'];
            } catch (\Exception $e) {
                $images->forget($key);
            }
        }
        return $images->values();
    }

}
