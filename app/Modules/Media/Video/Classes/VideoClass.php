<?php

namespace App\Modules\Media\Video\Classes;

use App\Modules\Media\Classes\MediaClass;
use App\Modules\Media\Classes\PreviewMediaClass;
use App\Modules\Media\Interfaces\MediaInterface;

class VideoClass implements MediaInterface
{

    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function Ratio()
    {
        $pathPreview = (new PreviewMediaClass($this->path))->getPath();
        $media = MediaClass::getMedia($pathPreview, 'image/jpeg');
        return $media->Ratio(true);
    }

    public function Orientation()
    {
        return 1;
    }
}
