<?php

namespace App\Http\Controllers;


use App\Traits\Api;
use App\Models\Album;
use App\Models\Image;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use App\Services\AlbumService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AlbumMoveImageRequest;
use App\Http\Requests\Album\AlbumStoreRequest;
use App\Http\Requests\Album\NewImageStoreRequest;

class AlbumController extends Controller
{

    use UploadFile , Api;

    protected AlbumService $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    public function index(){
        $ablums = Album::paginate();
        return view('albums.index',[
            'albums'=>$ablums
        ]);
    }

    public function create(){
        return view('albums.create');
    }

    public function store(AlbumStoreRequest $request){
        $album = Album::create([
            'name'=>$request->name,
            'image'=>$this->newImage(Album::$uploadPath,$request)
        ]);

            Session::flash('success','Album Created Successfully');
            return redirect()->back();
    }


    public function edit(Request $request ,Album $album){
        return view('albums.Edit',compact('album'));
    }


    public function update(Request $request ,Album $album){
        $album->update([
            'name'=>$request->name,
            'image'=>$this->newImage(Album::$uploadPath,$request,$album->image)
        ]);
        Session::flash('success','Album Updated Successfully');
        return redirect()->back();
    }

    public function show(Album $album){
        $images = Image::where('imageable_type','App\Models\Album')->where('imageable_id',$album->id)->paginate();
        return view('albums.show',compact('images','album'));
    }

    public function newAlbumImageCreate(Album $album){
        return view('albums.images.create',compact('album'));
    }

    public function newAlbumImageStore(NewImageStoreRequest $request,Album $album){
        $image = Image::create([
            'upload_name'=>$this->newImage(Album::$uploadPath,$request),
            'imageable_type'=>'App\Models\Album',
            'imageable_id'=>$album->id,
            'name'=>$request->name
        ]);

        Session::flash('success','Image Added Successfully');
        return redirect()->back();
    }

    public function albumImagedestroy(Image $image){
        $image_name = $image->upload_name;
        if(!$image->delete()){
            Session::flash('error','could not make this action please try again late');
        }else{
            Session::flash('success','Image Removed Successfully');
        }
        $this->removeFile(Album::$uploadPath,$image_name);
        return redirect()->back();
    }

    public function move(AlbumMoveImageRequest $request,Album $album){
        $album_id = $request->album_id;
        if(!$this->albumService->moveImages($album_id,$album)){
            Session::flash('error','something went wrong please try again later');
        }else{
            Session::flash('success','moved successfully');
        }
        return redirect()->back();
    }


    public function destroy(Request $reqest){
        $album_id = $reqest->get('album_id');

        $validator = Validator::make([
            'album_id'=>$album_id
        ],[
            'album_id'=>'required|gt:0|exists:albums,id'
        ]);

        if($validator->fails()){

        return $this->apiResponse('Validation Failed',null,$validator->messages(),400);

        }

        $album = Album::where('id',$album_id)->first();

        $album->delete();


        return $this->apiResponse('Album successfully deleted');
    }
}
