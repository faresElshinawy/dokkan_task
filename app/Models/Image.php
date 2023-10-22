<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'imageable_id',
        'imageable_type',
        'upload_name'
    ];

    public static $uploadPath = 'uploads/album_images';

    public function imageable(){
        return $this->morphTo();
    }

}
