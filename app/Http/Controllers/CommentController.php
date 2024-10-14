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
}
