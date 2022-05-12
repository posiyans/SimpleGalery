<?php

namespace App\Modules\Gallery\Repositories;

use App\Modules\Gallery\Models\MediaDirModel;

class GetChildrenForGalleryRepository
{

    private $gallery;

    public function __construct(MediaDirModel $gallery)
    {
        $this->gallery = $gallery;
    }

    public function run()
    {
        return MediaDirModel::where('parent_id', $this->gallery->id)->get();
    }

}
