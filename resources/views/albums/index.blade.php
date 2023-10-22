@extends('layouts.master')

@section('page-title', 'albums')


@section('content')
    <div class="container mx-auto p-6 bg-dark text-white">
        <h1 class="text-2xl font-semibold">Albums</h1>
        <div class="bg-gray-700 overflow-hidden shadow-md rounded-lg .content">
            <div class="api-response-alert"></div>
            <div class="flex justify-between items-center mb-4 ">
                <a href="{{ route('albums.create') }}"
                    class="create-button bg-green-500 hover:bg-green-600 text-white font-semibold m-2 py-2 px-4 rounded d-flex justify-content-end ">Create
                    New Album</a>
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
                    @foreach ($albums as $album)
                        <tr class="hover:bg-gray-600 album-{{ $album->id }}">
                            <td class="px-4 py-2">{{ $album->id }}</td>
                            <td class="px-4 py-2">{{ $album->name }}</td>
                            <td class="px-4 py-2">
                                @if (File::exists(public_path(\App\Models\Album::$uploadPath) . '/' . $album->image))
                                    <img src="{{ asset(\App\Models\Album::$uploadPath . '/' . $album->image) }}"
                                        alt="Album Image" class="rounded-lg shadow-lg object-cover h-64 w-64">
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('albums.show', ['album' => $album->id]) }}"
                                    class="text-white-400 hover:underline mr-2">View</a>
                                <a href="{{ route('albums.edit', ['album' => $album->id]) }}"
                                    class="text-yellow-400 hover:underline mr-2">Edit</a>
                                <button class="text-red-400 hover:underline mr-2 delete-album"
                                    onclick="deleteAlbum({{ $album->id }}, {{ $album->images->count() }})">Delete</button>
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

    <div id="moveImagesModal"
        class="hidden fixed inset-0 z-50 overflow-auto bg-opacity-50 bg-black flex justify-center items-center">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-1/2">
            <h2 class="text-lg font-semibold mb-4">Move Images to Another Album</h2>
            <form class="move-image-form" method="POST">
                @csrf
                @method('put')
                <label for="Album" class="block font-semibold">Select New Album:</label>
                <select id="images_moved_album_id" name="album_id" class="w-full bg-gray-200 p-2 text-black rounded mt-2 ">
                    <option selected disabled>Select the Album</option>
                    @foreach ($albums as $album)
                        <option value="{{ $album->id }}" @selected(old('album_id') == $album->id)>{{ $album->name }}</option>
                    @endforeach
                </select>
                <div class="mt-4">
                    <button class="moveImagesButton bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600" >Move
                        Images</button>
                    <button class="deleteImagesButton bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Delete
                        Anyway</button>
                </div>
            </form>
        </div>
    </div>



@endsection


@section('js')

    <script>

        function deleteAlbum(album_id, images_count = null) {


            function deleteAjaxRequest(){
                $.ajax({
                            url: "{{ route('albums.destroy') }}",
                            type: 'post',
                            cache: false,
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'album_id': album_id
                            },
                            success: function(data) {
                                if (data.code == 200) {
                                    Swal.fire({
                                        icon:'success',
                                        title:data.message
                                    })
                                    $(`.album-${album_id}`).remove();
                                }else if(data.code == 400){
                                    let errors = [];
                                    for(key in data.errors){
                                        if(data.errors.hasOwnProperty(key)){
                                            errors.push(data.errors[key]);
                                        }
                                        html = errors.join('\n');
                                        Swal.fire({
                                            icon:'error',
                                            title:data.message,
                                            showConfirmButton:false,
                                            html:html
                                        })
                                    }
                                }else{
                                    Swal.fire({
                                            icon:'error',
                                            title:data.message,
                                            showConfirmButton:false,
                                        })
                                }

                                $('#moveImagesModal').addClass('hidden');

                            }
                        })
            }

            let html = '';
            $(document).ready(function() {
                if (images_count > 0) {

                    $('#moveImagesModal').removeClass('hidden');
                    $('.deleteImagesButton').click(function(e) {
                        e.preventDefault();
                        deleteAjaxRequest()
                    });
                    $('.moveImagesButton').click(function(e){
                        e.preventDefault();
                        let url = "{{route('albums.move',['album'=>':album_id'])}}".replace(':album_id',album_id)
                        $('.move-image-form').attr('action',url).submit();

                    })

                } else {
                    deleteAjaxRequest()
                }
            });
        }
    </script>

@endsection
