<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function config() {
        return view('user.config');
    }
    
    public function update(Request $request) {
        //Conseguir el usuario identificado
        $user = \Auth::user() ;
        $id = $user->id; //Barra invertida delante de Auth para evitar problemas ya que no tenemos ningún namespace indicao
        
        //Validación del formulario
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'. $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. $id],
        ]);
       
        //Recoger los datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
        //ASignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;
        
        //Subir la imagen
        $image_path = $request->file('image_path'); //Ahora no sería $request->input, sino file (por motivos obvios)
        if($image_path){
            //Dar nombre único
            $image_path_name = time().$image_path->getClientOriginalName(); 
            /*Hace que el nombre del archivo sea único mediante la concatenación del tiempo
             *  con el nombre del fichero original cuando lo suibe el usuario             
             */
            
            //Guardar imagen en la carpeta storage/app/users
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            /* Objeto Storage, su método disk, junto el nombre del disco donde guardaremos 
             * la imagen (anteriormente creado 'users') debe ir acompañado del nombre que 
             * recibirá el archivo ($image_path_name) y del propio arhcivo a subir (para ello
             * usamos el objeto File::get, para obtener el archivo de la carpeta temporal 
             * donde se encuentra la propia imagen subida por el usuario).             
             */
            
            //Settear el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }
        
        //Ejecutar consulta y cambios en la BBDD
        $user->update();
        
        //Redirección
        return redirect()->route('config')
                         ->with(['message'=>'Usuario actualizado correctamente']);
        
    }
    
    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);
        return new Response ($file, 200);
    }
}
