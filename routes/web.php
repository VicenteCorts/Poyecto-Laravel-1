<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', function () {
    echo "<h1>Hola mundo</h1>";
    
    try {
        \DB::connection()->getPDO();
        echo \DB::connection()->getDatabaseName();
        } catch (\Exception $e) {
        echo 'None';
    }
    
});
