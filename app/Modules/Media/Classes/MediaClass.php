<?php

namespace App\Modules\Media\Classes;

use App\Modules\Media\Images\Classes\ImageClass;
use App\Modules\Media\Video\Classes\VideoClass;


class MediaClass
{

    public static function getMedia($path, $mimeType)
    {
        try {
//            $mimeType = mime_content_type($path);
            $type_ar = explode('/', $mimeType);
//            dd($type_ar);
            $type = $type_ar[0];
            switch ($type) {
                case 'image':
                    $object = new ImageClass($path);
                    break;
                case 'video':
                    $object = new VideoClass($path);
                    break;
                default:
                    throw new \Exception('Данный тип не подерживается');
            }
        } catch (\Exception $e) {
            throw new \Exception('Данный тип не подерживается');
        }
        return $object;
    }


}
