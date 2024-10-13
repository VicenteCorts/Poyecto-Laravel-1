<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class ImageController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }
    
    public function create() {
        return view('image.create');
    }
    
    public function save(Request $request) {
        
        //Validación
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' =>['required', 'image'],
//            'image_path' =>['required', 'mimes:jpg,jpeg,png,gif'], MIMES: PARA DETERMINAR EL FORMATO EXACTO DEL ARCHIVO
        ]);
        
        //Variables del formulario
        $image_path = $request->file('image_path');
        $description = $request->input('description');
        
        //Asignar valores al objeto -> primero añadir: use App\Models\Image;
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
//      $image->image_path = null;
        $image->description = $description;

        
        //Subir imagen a disco virtual de Laravel -> primero añadir: use Illuminate\Support\Facades\File; Y use Illuminate\Support\Facades\Storage;
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }
        
                      
//        var_dump($image_path_name);
//        die();
        
        // Guardar Obajeto Imagen en BBDD
        $image-> save();
        
        //Redirección a la ruta home
        return redirect()->route('home')->with([
           'message' => 'La Foto ha sido subida correctamente' 
        ]);
    }
    
    public function getImage($filename) {
        $file = Storage::disk('imagenes')->get($filename);
        return new Response($file, 200);
    }
    
    public function detail($id) {
        $image = Image::find($id);
        
        return view('image.detail',[
            'image' => $image
        ]);
    }
}
