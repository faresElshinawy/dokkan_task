@extends('layouts.master')

@section('page-title','Images')


@section('content')
<div class="container mx-auto p-6 bg-dark text-white">
    <h1 class="text-2xl font-semibold">Images / Add</h1>


    <div class="bg-gray-700 overflow-hidden shadow-md rounded-lg mt-4 p-4">
        <form action="{{route('albums.newImage.store',['album'=>$album->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-white font-semibold">Image Name:</label>
                <input type="text" name="name" value="{{old('name')}}"  class="w-full px-3 py-2 bg-gray-800 text-white border rounded-lg focus:outline-none focus:border-blue-500" >
            </div>
            <div class="mb-4">
                <label for="image" class="block text-white font-semibold">Image:</label>
                <input type="file" name="image"  class="w-full px-3 py-2 bg-gray-800 text-white border rounded-lg focus:outline-none focus:border-blue-500" accept="image/*" >
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Create Album</button>
        </form>
    </div>
</div>



@endsection

