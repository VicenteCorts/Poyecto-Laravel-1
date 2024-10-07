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
        
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'. $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. $id],
        ]);
       
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
    }
}
