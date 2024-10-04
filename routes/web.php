<?php

//use Illuminate\Support\Facades\Route;
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
