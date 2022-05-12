<?php

namespace App\Modules\Media\Video\Classes;

use App\Modules\Media\Abstracts\AbstractPreviewMedia;
use App\Modules\Storage\Classes\StorageFileClass;

class PreviewVideoClass extends AbstractPreviewMedia
{

    protected function run()
    {
        $this->createScreenshot();
    }

    /**
     * @throws \Exception
     */
    private function createScreenshot()
    {
        $hash = StorageFileClass::getHash($this->path);
        $path = StorageFileClass::getCachePathForHash($hash);
        (new GenerateVideoScreenshots())->generateScreenshot($this->path, $path);
        $this->preview_path = $path;
    }


}
