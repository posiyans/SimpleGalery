<?php

namespace App\Modules\Media\Images\Classes;

use App\Modules\Media\Abstracts\AbstractPreviewMedia;
use App\Modules\Storage\Classes\StorageFileClass;

class PreviewImageClass extends AbstractPreviewMedia
{

    private $image;
    private $virtual_image;

    protected function run()
    {
        $this->createImage();
        $this->resizeImage();
        $this->rotateImage();
        $this->saveImage();
    }

    private function createImage()
    {
        $type = exif_imagetype($this->path);
        $allowedTypes = [1, 2, 3, 6]; // gif, jpg, png, bmp
        if (!in_array($type, $allowedTypes)) {
            return false;
        }
        switch ($type) {
            case 1 :
                $this->image = imageCreateFromGif($this->path);
                break;
            case 2 :
                $this->image = imageCreateFromJpeg($this->path);
                break;
            case 3 :
                $this->image = imageCreateFromPng($this->path);
                break;
            case 6 :
                $this->image = imageCreateFromBmp($this->path);
                break;
            default:
                throw new \Exception('Не поддерживаемый тип');
        }

    }

    private function resizeImage()
    {
        $width = imagesx($this->image);
        $height = imagesy($this->image);
//        $desired_height = floor($height * ($this->desired_width / $width));
        $desired_width = floor($width * ($this->desired_height / $height));
        $this->virtual_image = imagecreatetruecolor($desired_width, $this->desired_height);
        imagecopyresampled($this->virtual_image, $this->image, 0, 0, 0, 0, $desired_width, $this->desired_height, $width, $height);
    }

    private function rotateImage()
    {
        if (($degrees = $this->getDegreesForRotate($this->path))) {
            $this->virtual_image = imagerotate($this->virtual_image, $degrees, 0);
        }
    }

    private function saveImage()
    {
        $hash = StorageFileClass::getHash($this->path);
        $path = StorageFileClass::getCachePathForHash($hash);
        imagejpeg($this->virtual_image, $path);
        $this->preview_path = $path;
    }

    public static function getDegreesForRotate($imgPath)
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
