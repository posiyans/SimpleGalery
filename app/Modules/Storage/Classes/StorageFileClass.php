<?php

namespace App\Modules\Storage\Classes;

use App\Modules\Media\Abstracts\AbstractPreviewMedia;
use App\Modules\Media\Images\Classes\PreviewImageClass;
use App\Modules\Media\Video\Classes\PreviewVideoClass;


class StorageFileClass
{




    public static function getCachePathForHash($hash)
    {
        $folder1 = substr($hash, 0,1);
        $folder2 = substr($hash, 1,1);
        $dir = __DIR__ . '/../../../../storage/cache/' . $folder1 . '/' . $folder2 . '/' ;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $path = $dir . $hash;
        return $path;
    }

    public static function getHash($path)
    {
        $hash = md5_file($path);
        return $hash;
    }
}
