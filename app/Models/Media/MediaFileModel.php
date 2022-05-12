<?php

namespace App\Models\Media;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFileModel extends Model
{
    use HasFactory;
    protected $casts = [
        'exif' => 'array',
    ];


}
