<?php

namespace App\Modules\Media\Images\Classes;

use App\Modules\Media\Abstracts\AbstractPreviewMedia;
use App\Modules\Media\Classes\PreviewMediaClass;
use App\Modules\Media\Interfaces\MediaInterface;
use App\Modules\Storage\Classes\StorageFileClass;
use Illuminate\Support\Facades\Storage;

class ImageClass implements MediaInterface
{

    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function Ratio($forPreview = false)
    {
        return self::getRatio($this->path, $forPreview);
    }

    public static function getRatio($path, $forPreview = false)
    {
        $ratio = self:: getRatioForPath($path);
        if ($forPreview) {
            $rotate = self::getDegreesForRotate($path);
            if ($rotate && $rotate != 0 && ($rotate == 270 || $rotate == 90)) {
                $ratio = 1 / $ratio;
            }
        }
        return $ratio;
    }

    public function Orientation()
    {
        return self::getOrientation($this->path);
    }

    public static function getRatioForPath($path)
    {
        list($width, $height, $type, $attr) = getimagesize($path);
        $ratio = 16 / 9;
        if ($height && $width) {
            $ratio = $width / $height;
        }
        return $ratio;
    }

    public static function getOrientation($path)
    {
        $orientation = 1;
        if (function_exists('exif_read_data')) {
            $exif = @exif_read_data($path);
            if($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
            }
        }
        return $orientation;
    }


    public static function getDegreesForRotate($imgPath)
    {
        $orientation = self::getOrientation($imgPath);
        $deg = false;
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
        return $deg;
    }


}
