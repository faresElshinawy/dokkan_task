<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Image;
use App\Traits\UploadFile;

class AlbumService {

    use UploadFile;

    public function moveImages($album_id,Album $album){
        foreach($album->images as $image){
            Image::create([
                'upload_name'=>$image->upload_name,
                'imageable_type'=>'App\Models\Album',
                'imageable_id'=>$album_id,
                'name'=>$image->name
            ]);
        }

        $images = Image::where('imageable_type','App\Models\Album')->where('imageable_id',$album->id)->pluck('id');

        if(Image::whereIn('id',$images)->delete() &&  $album->delete()){
            return true;
        }

        return false;
    }

}
