<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function config() {
        return view('user.config');
    }
    
    public function update(Request $request) {
        $id = \Auth::user()->id; //Barra invertida delante de Auth para evitar problemas ya que no tenemos ningún namespace indicao
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
//        var_dump($id);
//        var_dump($name);
//        var_dump($email);
//        die();
        
    }
}
