@extends('layouts.master')

@section('page-title','albums')


@section('content')
<div class="container mx-auto p-6 bg-dark text-white">
    <h1 class="text-2xl font-semibold">Albums</h1>
    <div class="bg-gray-700 overflow-hidden shadow-md rounded-lg .content">
        <div class="flex justify-between items-center mb-4 ">
            <a href="{{route('albums.create')}}"  class="create-button bg-green-500 hover:bg-green-600 text-white font-semibold m-2 py-2 px-4 rounded d-flex justify-content-end ">Create New Album</a>
        </div>
        <table class="min-w-full">
            <thead class="bg-gray-600">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Image</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($albums as $album)
                    <tr class="hover:bg-gray-600">
                        <td class="px-4 py-2">{{ $album->id }}</td>
                        <td class="px-4 py-2">{{ $album->name }}</td>
                        <td class="px-4 py-2">
                            @if (File::exists(public_path(\App\Models\Album::$uploadPath). '/' . $album->image))
                                <img src="{{ asset(\App\Models\Album::$uploadPath . '/' . $album->image) }}" alt="Album Image" class="rounded-lg shadow-lg object-cover h-64 w-64">
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{route('albums.show',['album'=>$album->id])}}" class="text-white-400 hover:underline mr-2">View</a>
                            <a href="{{route('albums.edit',['album'=>$album->id])}}" class="text-yellow-400 hover:underline mr-2">Edit</a>
                            <a href="" class="text-red-400 hover:underline mr-2">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="bg-gray-700 p-4 mt-4 rounded-lg">
            {{ $albums->links('pagination::simple-tailwind') }}
        </div>
    </div>
</div>



@endsection

