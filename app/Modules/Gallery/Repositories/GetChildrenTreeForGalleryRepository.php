<?php

namespace App\Modules\Gallery\Repositories;

use App\Modules\Gallery\Models\MediaDirModel;

class GetChildrenTreeForGalleryRepository
{

    private $gallery;

    public function __construct(MediaDirModel &$gallery)
    {
        $this->gallery = $gallery;
    }

    public function run()
    {
        $childrens = (new GetChildrenForGalleryRepository($this->gallery))->run();
        if (count($childrens) > 0 ) {
            foreach ($childrens as $children) {
                (new GetChildrenTreeForGalleryRepository($children))->run();
            }
            $this->gallery->children = $childrens;
        }
        return $this->gallery;
    }

}
