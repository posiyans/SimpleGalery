<?php

namespace App\Http\Controllers\Media\Folder;

use App\Http\Controllers\Controller;
use App\Models\Media\MediaFileModel;
use App\Modules\Media\Classes\PreviewMediaClass;
use App\Modules\Media\Video\Classes\GenerateVideoScreenshots;
use App\Modules\Storage\Classes\StorageFileClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GetImageForGalleryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $gallery_id = $request->id;
        $preview = $request->preview;
        $gallery = MediaFileModel::find($gallery_id);
        if ($gallery) {
            if ($preview) {
                $path = StorageFileClass::getCachePathForHash($gallery->hash);
                if (!file_exists($path)) {
                    $fullPath = Storage::path($gallery->path);
                    $path = (new PreviewMediaClass($fullPath))->getPath();
                }
                return response()->download($path);
            }
            return response()->download(Storage::path($gallery->path));
        }
        return response()->download(__DIR__ . '/no-find.jpg');
    }


    private function generateThumbnail(MediaFileModel $img, $desired_width)
    {
        $path = __DIR__.'/../../../../../storage/cache/' . $img->hash;
        if (!file_exists($path)) {
            $type = Storage::mimeType($img->path);
            switch ($type) {
                case 'image/jpeg':
                    $this->fromJpg($img, $desired_width);
                    break;
                case 'video/mp4':
                    $this->fromVideo($img, $path);
                    break;
                default:
                    $path = __DIR__ . '/no-find.jpg';
            }

        }
        return response()->download($path);
    }

    private function fromVideo(MediaFileModel $img, $path)
    {
        $file = (new GenerateVideoScreenshots())->generateScreenshot(Storage::path($img->path), $path);
        dd($file);
    }

    private function fromJpg(MediaFileModel $img, $desired_width)
    {
        try {
            $path = __DIR__ . '/../../../../../storage/cache/' . $img->hash;
            $full_path = Storage::path($img->path);
            $source_image = imagecreatefromjpeg($full_path);
            $width = imagesx($source_image);
            $height = imagesy($source_image);

            /* find the "desired height" of this thumbnail, relative to the desired width  */
            $desired_height = floor($height * ($desired_width / $width));

            /* create a new, "virtual" image */
            $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

            /* copy source image at a resized size */
            imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
            if (($degrees = $this->getDegreesForRotate($full_path))) {
                $virtual_image = imagerotate($virtual_image, $degrees, 0);
            }
            /* create the physical thumbnail image to its destination */
            imagejpeg($virtual_image, $path);
        } catch (\Exception $e) {

        }
    }

    private function getDegreesForRotate($imgPath)
    {
        $deg = false;
        if (function_exists('exif_read_data')) {
            $exif = exif_read_data($imgPath);
            if($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if($orientation != 1){
                    switch ($orientation) {
                        case 3:
                            $deg = 180;
                            break;
                        case 6:
                            $deg = 270;
                            break;
                        case 8:
                            $deg = 90;
                            break;
                    }
                }
            }
        }
        return $deg;
    }

}
