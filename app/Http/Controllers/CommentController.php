<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function save(Request $request) {

        //Validación
        $validate = $request->validate([
            'image_id' => 'numeric|required',
            'content' => 'string|required',
        ]);

        //Recoger Datos
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //Asignación de valores al nuevo objeto
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //Guardamos en la BBD
        $comment->save();

        //Redirección
        return redirect()->route('image.detail', ['id' => $image_id])
                        ->with(['message' => 'Comentario añadido correctamente'
        ]);
    }

    public function delete($id) {
        //Conseguir datos del usuario logeado
        $user = \Auth::user();

        //Conseguir objeto del comentario
        $comment = Comment::find($id);

        //Comprobar si soy el dueño del comentario o publicación
        if ($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)) {
            
            //Borrar comentario de la BBDD
            $comment->delete();

            //Redirección
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                            ->with(['message' => 'Comentario eliminado correctamente'
            ]);
        } else {
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                            ->with(['message' => 'No se ha podido eliminar el comentario'
            ]);
        }
    }
}
