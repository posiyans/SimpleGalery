<?php

namespace App\Modules\Media\Interfaces;

interface PreviewMediaInterface
{

    public function __construct($path);
    public function setHeight(int $height);
//    public function run();
    public function getPath();

}
