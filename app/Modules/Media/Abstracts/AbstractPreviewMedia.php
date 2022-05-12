<?php

namespace App\Modules\Media\Abstracts;

use App\Modules\Media\Interfaces\PreviewMediaInterface;


abstract class AbstractPreviewMedia implements PreviewMediaInterface
{

    protected $path;
    protected $preview_path;
    protected $desired_height;

    public function __construct($path)
    {
        $this->path = $path;
        $this->desired_height = 600;
        $this->preview_path = false;
    }

    public function setHeight(int $height)
    {
        $this->desired_height = $height;
        return $this;
    }

    protected function run()
    {

    }

    public function getPath()
    {
        try {
            if (!$this->preview_path) {
                $this->run();
            }
        } catch (\Exception $e) {
            $this->preview_path = __DIR__ . '/no-find.jpg';
        }
        return $this->preview_path;
    }

}
