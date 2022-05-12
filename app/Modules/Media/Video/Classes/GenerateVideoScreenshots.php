<?php

namespace App\Modules\Media\Video\Classes;


use Exception;
use function env;

class GenerateVideoScreenshots
{

    private $ffmpeg;
    private $extension = '.jpg';

    /**
     * PapVideoScreenshots constructor.
     *
     */
    public function __construct()
    {
        $this->ffmpeg = env('FFMPEG_PATH');
    }

    public function generateScreenshot($video_file, $output_path = '')
    {
        if (empty($video_file)) {
            throw new Exception('Please provide video file absolute path');
        }

        if (!is_file($video_file)) {
            throw new Exception('Given path is not a valid file path');
        }
//        $this->video_file = $video_file;
        $screenshot_path = $output_path . $this->extension;
        $command = $this->ffmpeg .' -i '.$video_file.' -ss 00:00:01 -vframes 1 ' . $screenshot_path . ' 2>&1';

        $output = shell_exec($command);

        rename($screenshot_path, $output_path);
        if (is_file($output_path)) {
            return $screenshot_path;
        } else {
            throw new Exception('Error generating screenshot: ' . $output);
        }
    }

}
