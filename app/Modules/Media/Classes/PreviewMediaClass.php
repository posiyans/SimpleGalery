<?php

namespace App\Modules\Media\Classes;

use App\Modules\Media\Abstracts\AbstractPreviewMedia;
use App\Modules\Media\Images\Classes\PreviewImageClass;
use App\Modules\Media\Video\Classes\PreviewVideoClass;


class PreviewMediaClass extends AbstractPreviewMedia
{

    private $type;

    private function setType()
    {
        $mimeType = mime_content_type($this->path);
        $type_ar = explode('/', $mimeType);
        $this->type = $type_ar[0];
    }

    public function run()
    {
//        try {
            $this->setType();
            switch ($this->type) {
                case 'image':
                    $object = new PreviewImageClass($this->path);
                    break;
                case 'video':
                    $object = new PreviewVideoClass($this->path);
                    break;
                default:
                    throw new \Exception('Данный тип не подерживается');
            }
            $object->setHeight($this->desired_height);
            $this->preview_path = $object->getPath();
//        } catch (\Exception $e) {
//            $this->preview_path = __DIR__ . '/no-find.jpg';
//        }
        return $this;
    }

}
