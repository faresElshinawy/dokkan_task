<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::group([
    'middleware'=>'auth'
],function (){


    Route::group([
        'prefix'=>'albums',
        'as'=>'albums.',
        'controller'=>AlbumController::class
    ],function (){
        Route::get('/','index')->name('all');
        Route::get('/show/{album}','show')->name('show');
        Route::get('/create','create')->name('create');
        Route::post('/store','store')->name('store');
        Route::get('/edit/{album}','edit')->name('edit');
        Route::put('/update/{album}','update')->name('update');
        Route::get('new-image/{album}','newAlbumImageCreate')->name('newImage.create');
        Route::post('new-image-store/{album}','newAlbumImageStore')->name('newImage.store');
        Route::delete('destroy-album-image/{image}','albumImagedestroy')->name('newImage.destroy');
        Route::put('/move-images/{album}','move')->name('move');
    });





});

require __DIR__.'/auth.php';
