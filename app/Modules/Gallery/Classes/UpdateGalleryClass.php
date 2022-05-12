<?php

namespace  App\Modules\Gallery\Classes;

use App\Modules\Gallery\Models\MediaDirModel;


class UpdateGalleryClass
{
    private $gallery;

    public function __construct(MediaDirModel $gallery)
    {
        $this->gallery = $gallery;
    }

    public function update($opt)
    {
        $this->gallery->fill($opt);
        return $this;
    }



    public function run()
    {
        if ($this->gallery->save()) {
            return $this->gallery;
        }
        throw new \Exception('Ошибака обновления');

    }

}
