<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user = \Auth::user();
        $likes = Like::where('user_id' , $user->id)
                ->orderBy('id', 'desc')
                ->paginate(5);
        return view('like.index', [
            'likes' => $likes
        ]);
    }

    public function like($image_id) {
        //Recoger datos del usuario y de la imagen
        $user = \Auth::user();

        //Condición para que solo se pueda dar un like por persona a cada foto
        $isset_like = Like::where('user_id', $user->id)
                ->where('image_id', $image_id)
                ->count();

        //var_dump($isset_like);
        //die();

        if ($isset_like == 0) {//Si con la condición no sacamos ningún registro-> creamos el objeto y lo guardamos
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int) $image_id; //Para evitar que recoja el dato como string
            //Guardar objeto Like() en BBDD
            $like->save();

            //En este caso no hacmeos redirección porque va a ser una acción AJAX
            //var_dump($like);

            return response()->json([
                        'like' => $like
            ]);
        } else {
            return response()->json([
                        'message' => 'El like ya existe'
            ]);
        }
    }

    public function dislike($image_id) {
        //Recoger datos del usuario y de la imagen
        $user = \Auth::user();

        //Condición para que solo se pueda dar un like por persona a cada foto
        $like = Like::where('user_id', $user->id)
                ->where('image_id', $image_id)
                ->first(); //NOS PERMITE SACAR UN ÚNICO OBJETO DE LA BBD

        if ($like) {//Si obtenemos un objeto like de la BBDD:
            //Eliminamos dicho objeto Like() de la BBDD
            $like->delete();

            return response()->json([
                        'like' => $like,
                        'message' => 'Has dado dislike'
            ]);
        } else {
            return response()->json([
                        'message' => 'El like NO existe'
            ]);
        }
    }
}
