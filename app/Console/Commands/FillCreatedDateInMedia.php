<?php

namespace App\Console\Commands;

use App\Models\Media\MediaDirModel;
use App\Models\Media\MediaFileModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FillCreatedDateInMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fill-create-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Заполнить дату создания в моделях';

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
        $files = MediaFileModel::where('date', null)->get();
        foreach ($files as $file) {
            $path = Storage::path($file->path);
            echo $file->name;
//            $exif = exif_read_data($path);

            $exif = @exif_read_data($path, 0, true);
            if (isset($exif['EXIF']['DateTimeOriginal'])) {

//                echo $file->name;
                echo ' Ok';
                $file->date = $exif['EXIF']['DateTimeOriginal'];
                $file->save();
//                echo $exif['EXIF']['DateTimeOriginal'];
            } else {
                $this->getDateFromName($file);
                //print_r($exif);
            }
//
//            echo "File Date Time: ".date ("F d Y H:i:s.",$exif['EXIF']['DateTimeOriginal']);
            echo PHP_EOL;
        }
    }

    private function getDateFromName($file)
    {

        $number = preg_replace('/[^0-9]/', '', $file->name);
        if (strlen($number) == 14 || strlen($number) == 15) {
            $date = substr($number, 0, 4);
            $date .= '-'. substr($number, 4, 2);
            $date .= '-'. substr($number, 6, 2);
            $date .= ' '. substr($number, 8, 2);
            $date .= ':'. substr($number, 10, 2);
            $date .= ':'. substr($number, 12, 2);
            try {
                $file->date = $date;
                $file->save();
                echo ' Ok';
            } catch (\Exception $e) {
                echo ' Error!';
            }
            return;
        }
        if (strlen($number) == 13) {
            $date = substr($number, 0, 4);
            $date .= '-'. substr($number, 4, 2);
            $date .= '-'. substr($number, 6, 2);
            $date .= ' '. substr($number, 8, 2);
            try {
                $file->date = $date;
                $file->save();
                echo ' Ok';
            } catch (\Exception $e) {
                echo ' Error!';
            }
            return;
        }
        echo '--';
        echo $number;
        echo '--';
        echo strlen($number);
        echo '--';
        echo 'no -found';
    }

}
