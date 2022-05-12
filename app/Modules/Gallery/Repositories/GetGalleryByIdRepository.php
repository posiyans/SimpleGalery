<?php

namespace App\Modules\Gallery\Repositories;

use App\Modules\Gallery\Models\MediaDirModel;

class GetGalleryByIdRepository
{

    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function run()
    {
        $gallery = MediaDirModel::find($this->id);
        if ($gallery) {
            return $gallery;
        }
        throw new \Exception('Галерея нре найдна');
    }
}
