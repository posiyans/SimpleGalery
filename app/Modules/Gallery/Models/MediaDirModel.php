<?php

namespace App\Modules\Gallery\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaDirModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'access',
        'name'
    ];

}
