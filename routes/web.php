<?php

use Illuminate\Support\Facades\Route;
//use App\Models\Image;
//use App\Models\Comment;
//use App\Models\Like;
//use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

/*
Route::get('/', function () {
    echo "<h1>Hola mundo</h1>";
    
    try {
        \DB::connection()->getPDO();
        echo "BASE DE DATOS: ".\DB::connection()->getDatabaseName();
        } catch (\Exception $e) {
        echo 'None';
    }
    echo "<hr/>";
    
    //Sacar imágenes por ORM
    $images = Image::all();
    foreach($images as $image){
        echo $image->image_path."<br/>";
        echo $image->description."<br/>";
        echo $image->user->name.' '.$image->user->surname."<br/>";
        
        foreach ($image->comments as $comment){
            echo $comment->content."<br/>";
        }
        
        echo "<hr/>";
//        var_dump($image);
    }
    die();
});
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/configuracion', [App\Http\Controllers\UserController::class, 'config'])->name('config');
Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::get('/user/avatar/{filename}', [App\Http\Controllers\UserController::class, 'getImage'])->name('user.avatar');
Route::get('/subir-imagen', [App\Http\Controllers\ImageController::class, 'create'])->name('imagen.create');
Route::post('/image/save', [App\Http\Controllers\ImageController::class, 'save'])->name('image.save');
Route::get('/image/file/{filename}', [App\Http\Controllers\ImageController::class, 'getImage'])->name('image.file');
Route::get('/imagen/{id}', [App\Http\Controllers\ImageController::class, 'detail'])->name('image.detail');
Route::post('/comment/save', [App\Http\Controllers\CommentController::class, 'save'])->name('comment.save');
Route::get('/comment/delete/{id}', [App\Http\Controllers\CommentController::class, 'delete'])->name('comment.delete');
Route::get('/like/{id}', [App\Http\Controllers\LikeController::class, 'like'])->name('like.save');
Route::get('/dislike/{id}', [App\Http\Controllers\LikeController::class, 'dislike'])->name('like.delete');
Route::get('/likes', [App\Http\Controllers\LikeController::class, 'index'])->name('likes');
Route::get('/perfil/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
