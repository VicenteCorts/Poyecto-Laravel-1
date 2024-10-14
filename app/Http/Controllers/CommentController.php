<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function save(Request $request) {

        $validate = $request->validate([
            'image_id' => 'integrer|required',
            'content' => 'string|required',
        ]);

        $image_id = $request->input('image_id');
        $content = $request->input('content');

        var_dump($content);
        die();
    }
}
