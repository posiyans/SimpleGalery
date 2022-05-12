<?php

namespace App\Modules\Media\Interfaces;

interface MediaInterface
{

    public function __construct($path);
    public function Ratio();
    public function Orientation();
//    public function run();
//    public function getPath();

}
