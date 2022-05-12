<?php

namespace App\Http\Controllers\Media\Folder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GetFolderTreeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get(Request $request)
    {
        $primary_folder = $request->get('folder', '/');
        $folders = Storage::directories($primary_folder);
//        $data = $this->getNode($folder);
//        $data = $this->viewTree('/home/posiyans/', ' ');
        $data = [];
        foreach ($folders as $folder) {
            $label = explode('/',$folder);
            $data[] = [
                'label' => end($label),
                'path' => '/' . $folder
            ];
        }
        return $data;
    }

    private function viewTree( $folder) {
        // Получаем полный список файлов и каталогов внутри $folder
        $data = [];
        try {
            $files = scandir($folder);
            foreach( $files as $file )
            {
                // Отбрасываем текущий и родительский каталог
                if ( ( $file == '.' ) || ( $file == '..' ) || (mb_substr($file, 0, 1) == '.')) continue;
                // Получаем полный путь к файлу
                $path = $folder.'/'.$file;
                // Если это директория
                if ( is_dir( $path ) )
                {
                    $tmp = [
                        'label' => $file,
                        'path' => $path
                    ];
                    $children = $this->viewTree( $path);
                    if (count($children) > 0) {
                        $tmp['children'] = $children;
                    }
                    $data[] = $tmp;
                }
            }
        } catch (\Exception $e) {
            $tmp = [
                'label' => $folder .('error'),
                'path' => $folder
            ];
            $data[] = $tmp;
        }
        return $data;
    }

    private function getNode($folder) {
        // Получаем полный список файлов и каталогов внутри $folder
        $data = [];
        try {
            $files = scandir($folder);
            foreach( $files as $file )
            {
                // Отбрасываем текущий и родительский каталог
                if ( ( $file == '.' ) || ( $file == '..' ) || (mb_substr($file, 0, 1) == '.')) continue;
                // Получаем полный путь к файлу
                $path = $folder.'/'.$file;
                // Если это директория
                if ( is_dir( $path ) )
                {
                    $tmp = [
                        'label' => $file,
                        'path' => $path
                    ];
                    $childrens = scandir($path);
                    $child = false;
                    foreach ($childrens as $item) {
                        if ( ( $item == '.' ) || ( $item == '..' ) || (mb_substr($item, 0, 1) == '.')) continue;
                        $path_ch = $path.'/'.$item;
                        if (is_dir($path_ch))
                        {
                            $child = true;
                        }
                    }
                    $tmp['l'] = $child;
                    if ($child) {
                        $tmp['lazy'] = true;
                    }
                    $data[] = $tmp;
                }
            }
        } catch (\Exception $e) {
            $tmp = [
                'label' => $folder .('error'),
                'path' => $folder
            ];
            $data[] = $tmp;
        }
        return $data;
    }
}
