<?php

namespace App\Console\Commands;

use App\Models\Media\MediaDirModel;
use App\Models\Media\MediaFileModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FindNewMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:find-new-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Найти новые фото';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->ver2();
        return 1;
    }
    private function ver2()
    {
        $folders = MediaDirModel::all();
        foreach ($folders as $folder) {
            $files = Storage::allFiles($folder->path);
            foreach ($files as $file) {
                $path = '/' . $file;
                $name = explode('/', $file);
                $image = new MediaFileModel();
                $image->gallery_id = $folder->id;
                $image->path = $path;
                $image->hash = md5_file(Storage::path($file));
                $image->name = end($name);
                $image->size = Storage::size($file);
                $image->type = Storage::mimeType($file);
                try {
                    if ($this->checkUnique($image)) {
                        if ($image->save()) {
                            echo $path;
                            echo PHP_EOL;
                        }
                    }
                } catch (\Exception $e) {

                }

            }
        }
    }

    private function checkUnique(MediaFileModel $image, $checkHash = false)
    {
        $check = MediaFileModel::where('gallery_id', $image->gallery_id)
            ->where('name', $image->name)->first();
        if ($check) {
            return false;
        }
        if ($checkHash) {
            $check = MediaFileModel::where('hash', $image->hash)
                ->first();
            if ($check) {
                return false;
            }
        }
        return true;
    }

    private function ver1() {
        $folders = MediaDirModel::all();
        $images = MediaFileModel::all();
        foreach ($folders as $folder) {
            $dir = $folder->path;
            $files = array_diff(scandir($dir), ['..', '.']);
//            print_r($files);
            foreach ($files as $file) {
                $path = $folder->path . '/' . $file;
                $image = new MediaFileModel();
                $image->path = $path;
                $image->hash = md5_file($path);
                $image->name = $file;
                $image->size = filesize($path);
                $image->type = mime_content_type($path);
                try {
                    if ($image->save()) {
                        echo $path;
                        echo PHP_EOL;
                    }
                } catch (\Exception $e) {

                }

            }
//            return array_values($files);
        }
    }
}
