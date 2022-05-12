<?php

namespace App\Http\Repositories\Media\Folder;

use App\Http\Controllers\Controller;
use App\Models\Media\MediaDirModel;
use Illuminate\Http\Request;

/**
 * @deprecated
 */
class FolderAndChildrenRepository
{

    private $model;
    private $item;


    public function __construct(MediaDirModel $item)
    {
        $this->item = $item;
        $this->model = MediaDirModel::query();
        $this->model->where('parent_id', $item->id);
    }


    public function run()
    {
        $children = $this->model->get();
        if (count($children) > 0) {
            foreach ($children as $child) {
                (new FolderAndChildrenRepository($child))->run();
            }
            $this->item->children = $children;
        }
    }

    public static function all()
    {
        $primaryGalleries = MediaDirModel::query()->where('parent_id', null)->get();
        foreach ($primaryGalleries as $item) {
            (new FolderAndChildrenRepository($item))->run();
        }
        return $primaryGalleries;
    }

}
