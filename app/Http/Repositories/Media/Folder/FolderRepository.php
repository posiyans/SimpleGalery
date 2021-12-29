<?php

namespace App\Http\Repositories\Media\Folder;

use App\Http\Controllers\Controller;
use App\Models\Media\MediaDirModel;
use Illuminate\Http\Request;

class FolderRepository
{

    private $model;


    public function __construct()
    {
        $this->model = MediaDirModel::query();
    }


    public function getList()
    {

        return $this->model->get();
    }

}
