<?php

namespace App\Http\Controllers;

use App\Http\Requests\Album\AlbumStoreRequest;
use App\Models\Album;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AlbumController extends Controller
{

    use UploadFile;

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
            'image'=>$this->newImage(Album::$uploadPath,$request->image)
        ]);
        Session::flash('success','Album Updated Successfully');
        return redirect()->back();
    }
}
