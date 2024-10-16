<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;
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
            'image_path' => ['required', 'image'],
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
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }


//        var_dump($image_path_name);
//        die();
        // Guardar Obajeto Imagen en BBDD
        $image->save();

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

        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function delete($id) {
        //Conseguir datos del usuario logeado
        $user = \Auth::user();

        //Conseguir objeto de la imagen
        $image = Image::find($id);

        //Localizar Comentarios y Likes correspondientes a la imagen en proceso de borrado
        //Si la imagen tiene registros asociados nos dará error indicando que no se puede eliminar
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        //Comprobar si soy el dueño de la imagen
        if ($user && $image && ($image->user_id == $user->id)) {

            //Eliminar Comentarios asociados a la imagen
            if ($comments && count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }

            //Eliminar Likess asociados a la imagen
            if ($likes && count($likes) >= 1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }

            //Eliminar ficheros asociados a la imagen PELIGRO?
            Storage::disk('images')->delete($image->image_path);

            //Borrar Imagen de la BBDD
            $image->delete();

            //Mensaje final:
            $message = array('message' => 'La imagen se ha eliminado correctamente.');
        } else {
            //Mensaje final en caso de error
            $message = array('message' => 'Fallo a la hora de borrar la imagen.');
        }

        //Redirección
        return redirect()->route('home')->with($message);
    }

    public function edit($id) {
        //Conseguir datos del usuario logeado
        $user = \Auth::user();

        //Conseguir objeto de la imagen
        $image = Image::find($id);

        //Comprobar si soy el dueño de la imagen
        if ($user && $image && ($image->user_id == $user->id)) {

            //Redirección Success
            return view('image.edit', [
                'image' => $image
            ]);
        } else {
            //Redirección Fail
            return redirect()->route('home');
        }
    }

    public function update(Request $request) {
        //Validación
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' => ['image'],
        ]);
        
        //Recoger datos
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');
        
        //Conseguir objeto imagen de la BBDD
        $image = Image::find($image_id);
        $image->description = $description;

        //Subir imagen a disco virtual de Laravel -> primero añadir: use Illuminate\Support\Facades\File; Y use Illuminate\Support\Facades\Storage;
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }
        
        //Actualizar el registro del objeto imagen conseguido
        $image->update();
        
        //Redirección
        return redirect()->route('image.detail', ['id'=>$image->id])
                        ->with(['message' => 'Imagen actualizada con éxito']);
    }
}
