<?php

namespace App\Http\Controllers\Media\Folder;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Media\Folder\FolderAndChildrenRepository;
use App\Http\Repositories\Media\Folder\FolderRepository;
use App\Models\Media\MediaDirModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FolderResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $data = (new FolderRepository())->getList();
        $data = FolderAndChildrenRepository::all();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $request->path;
        $model = new MediaDirModel();
        $model->path = $path;
        $name = explode('/', $path);
        $model->name = end($name);
        if ($model->save()) {
            Storage::makeDirectory($path);
            return $model;
        }
        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = MediaDirModel::find($id);
        return $gallery;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $gallery = MediaDirModel::find($id);
       $images = Storage::allFiles($gallery->path);
       if (count($images) == 0 ) {
           Storage::deleteDirectory($gallery->path);
       }
       $gallery->delete();
       return true;
    }
}
