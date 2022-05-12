<?php

namespace App\Http\Controllers\Media\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Media\MediaDirModel;
use App\Models\Media\MediaFileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadFileInGalleryController extends Controller
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
        $gallery_id = $request->gallery;
        $gallery = MediaDirModel::find($gallery_id);
        if ($gallery) {
            $file = $request->file('media-file');
            $path = $gallery->path . '/' . $file->getClientOriginalName();
            if (file_exists($path)) {
                $md5 = MediaFileModel::query()->where('hash', md5_file($file))->first();
                if ($md5) {
                    $name = false;
                }else {
//                    $path = $gallery->path . '/' . time() .'_'. $file->getClientOriginalName();
                    $name = time() .'_'. $file->getClientOriginalName();
//                    Storage::putFileAs($gallery->path, $file, $name);
                }
                return md5_file($file);
            } else {
                $name =  $file->getClientOriginalName();
            }
            if ($name) {
                try {
                    $this->addModel($gallery, $file, $name);
                    Storage::putFileAs($gallery->path, $file, $name);
                    return 'ok';
                } catch (\Exception $e) {
                    return $e->getMessage();
                }

            }
            return 'duble';
//            $path = $gallery->path . '/' . $file->getClientOriginalExtension();
//
        }
//        $images = MediaFileModel::query()->limit(30)->get();
//        $images = MediaFileModel::query()->get();
        return 'no gallery';
    }

    private function addModel($gallery, $file, $name)
    {
//        Storage::putFileAs($gallery->path, $file, $name);
        $path = $gallery->path . '/' . $name;
        $fullPath = Storage::path($path);
        $image = new MediaFileModel();
        $image->gallery_id = $gallery->id;
        $image->path = $path;
        $image->hash = md5_file($file);
        $image->name = $name;
        $image->size = filesize($file);
        $image->type = $file->getClientMimeType();
        $image->user_id = Auth::id();
        $image->exif = [];
        $image->save();
    }

}
