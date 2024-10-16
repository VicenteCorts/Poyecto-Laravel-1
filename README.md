# PROYECTO LARAVEL - INSTAGRAM
## Clase 354
### Creando la BBDD
#### Tabla USERS
Debemos incluir algunos atributos que trabajan de fomra interna en Laravel como:
- role
- created_at
- updated_at
- remember_token
#### Tabla IMAGES
Debemos incluir algunos atributos que trabajan de fomra interna en Laravel como:
- user_id (relacionada con la tabla de USERS)
- image_path
- created_at
- updated_at
### Tabla COMMENTS
Debemos incluir algunos atributos que trabajan de fomra interna en Laravel como:
- user_id (relacionada con la tabla de USERS)
- image_id (relacionada con la tabla de IMAGES)
- image_path
- created_at
- updated_at
### Tabla LIKES
Debemos incluir algunos atributos que trabajan de fomra interna en Laravel como:
- user_id (relacionada con la tabla de USERS)
- image_id (relacionada con la tabla de IMAGES)
- image_path
- created_at
- updated_at

## Clase 355
### Instalación del proyecto Laravel
Abrimos la **consola de comandos** y nos dirigimos a la carpeta donde ubcaremos el proyecto. Una vez allí usamos el comando 
**$ composer create-project laravel/laravel 10proyecto-laravel "11.*" --prefer-dist**. También he decidido subir este proyecto 
como un **repositorio de github**. Para ello creamos un nuevo repositorio vacío en github y posterirmente empeamos los siguinetes 
cdcomandos comandos tras abrir el bash en la carpeta del proyecto:
- git init
- git add .
- git commit -m "Inicio Proyecto laravel"
- git branch -M main
- git remote add origin https://github.com/VicenteCorts/Poyecto-Laravel-1.git
- git push -u origin main

A continuación, aprovechamos que el proyecto está recien instalado para crear un **host virtual** para tener una url amigable:
- Nos dirigimos a localhost y clicamos en Herramientas>**Añadir un host virtual**
- Rellenamos los campos: 
- proyecto-laravel.com.devel
- a:/wamp64/www/master-php/10proyecto-laravel/public/
- PHP: 8.3.0
- **Reiniciamos el servidor web local**

## Clase 356
### Creación de la BBDD phpmyadmin-sql
Creamos un nuevo archivo en la raíz del proyecto "database.sql" para escribir todas las instrucciones SQL para la creación de BBDD.

Posteriormente abrimos la consola de MySQL y copiamos todo el código para ejecutarlo. Ya tendríamos nuestra BBDD creada y lista.
También podemos compilñar el código SQL a través de netbeans en uno de los botones superiores (a mi no me funciona).

## Clase 357
### Conexión a la BBDD
En el archivo .env de la raíz del proyecto debemos realizar la siguiente configuración:
- APP_URL=http://proyecto-laravel.com.devel/
- En el apartado de DB_CONNECTION:
```html
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_master
DB_USERNAME=root
DB_PASSWORD=
```
- Y finalmente debemos sustituir "database" por **"file"** en **SESSION_DRIVER=file**

- Para comprobar si la conexión se ha establecido correctamente podemos sustituir en el archivo web.php la ruta principal por:
```html
Route::get('/', function () {
    echo "<h1>Hola mundo</h1>";
    
    try {
        \DB::connection()->getPDO();
        echo \DB::connection()->getDatabaseName();
        } catch (\Exception $e) {
        echo 'None';
    }
    
});
```

## Clase 358
### Creando los Modelos o entidades
#### ORM: 
Eloquent - modelo de programación cuya misión es transformar las tablas de una base de datos de forma que las tareas básicas, que realizan los programadores, estén simplificadas-
- **En symfony es Doctrine**
### Ubicación
Los modelos se crean dentro de la carpeta app>models
- nos vamos a la consola, a la carpeta del proyecto
- $ php artisan make:model "nombre-del-modelo"
- Los modelos se guardan en Mayus y singular Image, Like, Comment, etc...

## Clase 359
### Configurando Modelos y sus relaciones
https://laravel.com/docs/11.x/eloquent-relationships#one-of-many-polymorphic-relations
En Laravel 11 se definen de fomra diferente a las clases de Victor
#### Entidad Comment
```html
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    
    //Relación Many to One
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    //Relación Many to One
    public function image(): BelongsTo {
        return $this->belongsTo(Image::class);
    }
}
```
#### Entidad Image
```html
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $table = 'images'; //Indicamos cual es la tabla que modifica este modelo
    protected $primaryKey = 'id';
    
    //Relación One to Many
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }
    
    //Relación One to Many
    public function likes(): HasMany{
        return $this->hasMany(Like::class);
    }
    
    //Relación Many to One
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    
}
```
#### Entidad Like
```html
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    protected $table = 'likes';
    protected $primaryKey = 'id';
    
    //Relación Many to One
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    //Relación Many to One
    public function image(): BelongsTo {
        return $this->belongsTo(Image::class);
    }
}
```
#### Entidad User
Añadimos:
```html 
use Illuminate\Database\Eloquent\Relations\HasMany;
//Relación One to Many
    public function images() : HasMany {
        return $this->hasMany(Image::class);
    }
```
- **Cabe hacer mención a la importancia de importar las librerias al principio y a saber la relación que existe entre las diferentes tablas para la hora de definirlas**

## Clase 360
### Rellenar la BBDD
Datos recogidos mediante Inserts en el documento de la raiz del proyecto **database.sql** previamente creado por nosotros.

## Clase 361
### Probando el ORM
- Abrimos web.php
- Importamos los modelos, ejemplo: use App\Models\Image;
- añadimos el siguinete código para ver si llegan los registros de la BBDD:
```html
//Sacar imágenes por ORM
    $images = Image::all();
    foreach($images as $image){
        var_dump($image);
    }
    die();
```
**O más elaborado:**
```html
//Sacar imágenes por ORM
    $images = Image::all();
    foreach($images as $image){
        echo $image->image_path."<br/>";
        echo $image->description."<br/>";
        echo "<hr/>";
//        var_dump($image);
    }
    die();
```
- Si quisiéramos sacar el usuario que ha creado cada imagen seguiríamos elk siguinete código: **echo $image->user->name.' '.$image->user->surname;**
- Si queremos rizar más el rizo y sacar además los comentarios asociados a cada imagen, sería con el siguiente código:
```html
//Sacar imágenes por ORM
    $images = Image::all();
    foreach($images as $image){
        echo $image->image_path."<br/>";
        echo $image->description."<br/>";
        echo $image->user->name.' '.$image->user->surname."<br/>";

        foreach ($image->comments as $comment){ //ESTE CÓDIGO
            echo $comment->content."<br/>";
        }

        echo "<hr/>";
//        var_dump($image);
    }
    die();
```
## Clase 362

### Login y Registro de Usuarios (Auth Laravel 11)

- https://laravel.com/docs/11.x/authentication#install-a-starter-kit
- En versiones anteriores de Laravel o si empleamos un kit de instalación inicial de Laravel, estos elementos de Registro, Login, Autenticación, etc... vienen ya por defecto. En caso de que instalemos Laravel mediante composer debemos hacer unas intalaciones y configuraciones para que estos archivos, ya predeterminados, se instalen y podamos hacer uso de ellos

#### Pasos para instalar Starter Kits

- https://laravel.com/docs/11.x/starter-kits#laravel-breeze
- https://www.youtube.com/watch?v=XupPp7xxGMM&ab_channel=JLuisDev

- Para **importar el "UI"** Empleamos los sigueintes comandos por consola (siguiendo la explicación del video 2º enlace)
- **composer require laravel/ui**

- Posteriormente importamos la librería de autenticación:
- **$ php artisan ui:auth** (yes)
- Con esto nos incluye en la carpeta views una carpeta **auth** y en la carpeta layouts-> **app.blade.php**

- Luego debemos **importar Bootstrap** usando:
- (Para más info: https://getbootstrap.com/)
- **$ php artisan ui bootstrap**
- **npm install**
- **npm run dev**

- Puede darse el caso, de que necesitemos node.js para ejecutar esos dos ultimos comandos e instalar bootstrap correctamente; para ello necesitmaos instalar node.js
- https://nodejs.org/en

#### Configuración adicional:
Por último para que la homepage de nuestro proyecto sea el login instalado a través de bootsstrap y todo el proceso anterior, debemos ir a web.php y sustituir la ruta del homeController por **'/'**.
- Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Además debemos modificar RegisterController para que al añadir un nuevo usuario nos redirija correctamente:
- (línea 31) **protected $redirectTo = '/';**

#### Resultado:
Con estas intalaciones ya tendríamos el layout de bootstrap corriendo (pantalla blanca con menu superior de Login y Registro)
- NOTA: al final del proyecto para compilar todo el proyecto al completo, será necesario ejecutar el comando: **npm run build**. Pero al final, de momento no.

## Clase 363
### Completar formulario de registro
Queremos que el formulario de registro incluya algunos campos extra de la tabla de usuarios, quepor defecto no están incluidos en dicho formulario, haciendo que al registrar un nuevo usuario queden campos vacíos en la BBDD.
- Nos dirigimos a views>auth>register.blae.php
- Añadimos los nuevos campos surname y nick -> cambiando todos los textos de "name" al texto correspondiente (coherencia)
- Luego nos vamos a nuestro modelo app>user.php y añadimos surname y nick (debemos añadir el 'role' para hacer que genere cambios en la BBDD también aunque lo dejemos predefinido más adelante):
```html
protected $fillable = [
        'role',
        'name',
        'surname',
        'nick',
        'email',
        'password',
    ];
```
- Ahora abrimos app>http>controllers>RegisterController.php
- Dentro modificamos la parte de "validator" para añadir los nuevos campos:
```html
protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
```
- Igualmente debemos modificar el método "create" de este archivo para añadir los nuevos campos (además añadimos el cmapo "role" pero de manera fija):
```html
protected function create(array $data)
    {
        return User::create([
	    'role'=> 'user',
            'name' => $data['name'],
            'surname' => $data['surname'],
            'nick' => $data['nick'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
```
- **Victor modifica el middleware pero en laravel 11 parece que no se tiene acceso a él**

- **Hacer mención a que he modificado en este punto todas las redirecciones a "/home/ por "/"**

## Clase 364
### Elementos del Menú
Nos dirigimos a views>layouts>app.blad.php
- Cambiamos el nombre de la aplicación directamente cambiando title y el <a> // sin embargo, accediando a config>app.php podemos cambiar la configuración de algunas variables como dicho nombre (aunque no sé como)
- Añadimos también los enlaces para el usuario autenticado que deseemos (Inicio y Subir foto en menú horizontal y dentro del drop-down menú dos "<a>" para añadir enlaces a mi perfil y a configuración.
```html
(...)
@else
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    Inicio
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    Subir imagen
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    
                                    <a class="dropdown-item" href="">
                                       Mi perfil
                                    </a>
                                    
                                    <a class="dropdown-item" href="">
                                       Configuración
                                    </a>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
```

## Clase 365
### Formulario de Configuración
- Lo primero es generar un nuevo controlador:
- **$ php artisan mak:controller UserController**
- app>http>controllers>UserController.php
```html
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function config() {
        return view('user.config');
    }
}
```
- Creamos dentro de views, la carpeta user y dentro de esta el archivo config.blade.php y le ponemos algo de contenido incial (simplemente para comprobar que funcione)
- Creamos la ruta en web.php para ir al método config del Controlador User: **Route::get('/configuracion', [App\Http\Controllers\UserController::class, 'config'])->name('config');**
- Volvemos a resources>views>layout>app.blade.php y modificamos el anlace de configuración: **<a class="dropdown-item" href="{{ route('config') }}">Configuración</a>**

Todo funciona correctamente
- Ahora debemos retocar la plantilla de config.blade.php haciendo que herede de alguna plantilla maestra para que tenga cohesión con el resto de la web
- Tomamos de referencia el código del archivo register.blade.php y lo editamos al gusto (cambiamos el título de la tarjeta, eliminamos los labels de password, etc...) 
- Lo importante es heredar el layout maestro con:
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Configuración de mi cuenta</div>
(...)
//Código abundante
(...)
@endsection
```

## Clase 366
### Recibir datos del usuario como values
Primero haremos que el formulario se rellene con los datos del usuario identificado. Para ello añadiremos los values utilizando el ORM para extraer los datos de la BBDD:
- Sustituir en el value de cada label {{old('nombre_atributo')}} por-> **value="{{ Auth::user()->name }}"**
### Recibir datos de formulario de Configuración
Creamos un método "update" en el Controlador de User (Atención al uso del objeto **Request**)
```html
public function update(Request $request) {
        $id = \Auth::user()->id; //Barra invertida delante de Auth para evitar problemas ya que no tenemos ningún namespace indicao
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
        //var_dump($id);
        //var_dump($name);
        //var_dump($email);
        //die();
    }
```
- También debemos crear la ruta para el submit del formulario de configuración (por post) en el arhcivo web.php: 
**Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');**
- Después debemos incluir este action al formulario-> **<form method="POST" action="{{ route('user.update') }}">**

## Clase 367
### Validar datos del fromularios
- https://laravel.com/docs/11.x/validation
- Validaremos el formulario en base a la request que nos llega en el método config de UserController. Para ello podemos tomar el fragmento de código de validación de RegisterController:
```html
$validate = $this->validate($request, [
 	    'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
]);
```
### Comprobar registros "únicos"
- Es interesante prestar atención a la norma de validación **'unique:users'** que valida que este dato sea único en la tabla de ususarios.
- Para mejorarla y hacer que ignorara los campos del usuario que estamos validadndo (permitiendo que pueda poner su mismo nick y su mismo email deberiamos generar las sigueintes líneas de códig:
´´´html
'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'. $id],
'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. $id],
```
## Clase 368
### Guardar datos en BBDD
Para actualizar la BBDD debemos asignar los valores de la $request al objeto usuario que está identificado:
```html
	//ASignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;
        
        //Ejecutar consulta y cambios en la BBDD
        $user->update();
```

En definitiva el código completo de este método quedaría de la sigueinte forma:
```html
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
			//ATENCIÓN CON LOS UNIQUE PARA LOS REGISTROS ÚNICOS
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
        
        //Ejecutar consulta y cambios en la BBDD
        $user->update();
        
        //Redirección
        return redirect()->route('config')
                         ->with(['message'=>'Usuario actualizado correctamente']);
        
    }
```

Para que el mensaje final fuera visible debemos incluir el siguiente código en la vista a la que nos redirecciona el return del **método update** anterior:
```html
@if(session('message'))
	<div class="alert alert-success">
		{{session('message')}}
	</div>
@endif
```
## Clase 369
### Preparación del formulario
Añadimos un bloque de código para incluir el label para la imagen de perfil:
```html
<div class="row mb-3">
	<label for="image_path" class="col-md-4 col-form-label text-md-end">{{ __('Avatar') }}</label>

	<div class="col-md-6">
		<input id="image_path" type="file" class="form-control @error('image_path') is-invalid @enderror" name="image_path" required autocomplete="image">

		@error('image_path')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
</div>
```
### Subir archivos al servidor
En Laravel, no podemos guardar las imágenes de forma "directa" en el sistema de archivos. En este caso se emplean una serie de **discos virtuales** (archivos: config>filesystems || storage)...
- Para comenzar el proceso de configuración para poder subir y almacenar archivos tipo imagen nos dirigiremos a la carpeta **storage/app** y crearemos dos carpetas nuevas dentro (users e images).
- Ahora nos dirigimos al archivo **filesystems.php** (dentro de la carpeta config).
- Aquí veremos los diferentes discos virtuales para almacenaje. 
- Copiamos el disco **public** y lo editamos (nombre y ruta) para que dirijan a las dos carpetas creadas en el primer paso (users e images) del siguiente modo:
```html
	'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],
        
        'users' => [
            'driver' => 'local',
            'root' => storage_path('app/users'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],
        
        'images' => [
            'driver' => 'local',
            'root' => storage_path('app/images'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],
```
### Más configuración en el Formulario y Método
Ahora que tenemos definidos los dos discos virtuales añadimos el enctype a la cabecera del formulario para permitir la subida de archivos:
```html
<form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
```

Ahora nos dirigimos al Controlador de User, al método update, para añadir la nueva función de subir imagen de perfil:
- En primer lugar debemos importar el objeto storage: **use Illuminate\Support\Facades\Storage;** y **use Illuminate\Support\Facades\File;**.
- Luego debemos incluir el código  para la subida de imágenes en el método **update**:
```html
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
```
- Como última instrucción, se debe eliminar el "require" del label image_path del formulario para evitar problemas a la hora de actualizar el usuario si no se sube imagen de perfil

## Clase 370
### Mostrar imagen Avatar
Creamos un nuevo método en el User Controller para recuperar la imagen guardada. (También debemos importar el objeto Response, emepleado en el método:
```html
use Illuminate\Http\Response;
(...)
    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);
        return new Response ($file, 200);
    }
```
Creamos la ruta para el nuevo método: **Route::get('/user/avatar/{filename}', [App\Http\Controllers\UserController::class, 'getImage'])->name('user.avatar');**
- Paramos por parámetro obligatorio **{filename}** para que el método funcione correctamente.
- Probando la url de ejemplo: http://proyecto-laravel.com.devel/user/avatar/1728289479cat.jpg nos devolvería una imagen pero sin formato (simbolos raros)
- Para que nos muestre la imagen debemos darle formato <img> 
- En nuestro caso la ubicaremos en el formulario de configuración de usuario (config.blade.php):
```html
<!--COMPROBAMOS SI EL USUARIO TIENE IMAGEN-->
@if(Auth::user()->image)
	<!--<img src="{{ url('/user/avatar/'.Auth::user()->image)}}"/>-->
	<img src="{{ route('user.avatar', ['filename' => Auth::user()->image])}}" class="avatar"/>
@endif				
```
- **Importante destacar que de ambas formas el resultado será el mismo**

### Estilos imagen Avatar
Añadimros la class="avatar" a la línea <img/> anterior y creamos una hoja de estilos css para editarla a nuestro gusto
- Esta hoja de estilos debe añadirse dentro de una carpeta llamada css, e incluida dentro de la carpeta public
- Victor incluye un nuevo archivo "style.css" dentro de la carpeta public/css/style.css
- ~Sin embargo en Laravel 11, esta se ubica en resources/css/app.css (creamos dentro de la carpeta css un archivo llamado **style.css**~
- incluimos los estilos que queremos añadir a la clase "avatar":
```html
.avatar{
    margin-bottom: 15px;
    width: 90px;
}
```
- Para cargar la nueva hoja de estilos, nos dirigimos a resources/views/layouts/app.blade.php
- Añadimos el link en dicho archivo: **<link href="{{asset('css/style.css')}}" rel="stylesheet">**

## Clase 371
### Creación de include poara el fragmento de mostrar el avatar
- Creamos unanueva carpeta dentro de resource/views/ llamada "includes" y dentro de esta creamos una rchivo avatar.blade.php
- Tomamos el dógio (Clase 370) para comprobar si el usuario tiene avatar, y lo pegamos en este nuevo archivo.
- Ahora volvemos a config.blade.php y sustituimos el bloque de código que ya hemos copiado en el archivo anterior por: **@include('includes.avatar')**

### Avatar en el Menú
Para modificar el menú superior, debemos trabajar en el archivo **resource/views/layouts/app.blade.php**
- Añadimos el siguiente fragmento para colocar la imagen usando el include anterior:
```html
<li class="nav-item">
	@include('includes.avatar')
</li>
```
- Retocamos un poco la vista del include añadiendo un div con la clase container-avatar
```html
@if(Auth::user()->image)
<div class='container-avatar'>
    <!--<img src="{{ url('/user/avatar/'.Auth::user()->image)}}"/>-->
    <img src="{{ route('user.avatar', ['filename' => Auth::user()->image])}}" class="avatar"/>
</div>
@endif
```
- Damos estilos a las diferentes manifestaciones del include (public/css/style.css)
```hml
form .avatar{
    margin-bottom: 15px;
    width: 90px;
}

.navbar .container-avatar{
    width: 40px;
    height: 40px;
    border-radius: 900px;
    overflow: hidden;
    margin-left: 20px;
}

.navbar .container-avatar img{
   height: 100%
}
```
## Clase 372
### "Solo para usuarios identificados"
En esta clase haremos que mediante un middleware, se nos deniegue la entrada a la aplicación en caso de no estar identificados.
- Para ello escribimos el siguiente código en UserController.php (extraido de HomeController.php):
```html
public function __construct(){
	$this->middleware('auth');
}
```
- **REALMENTE NO ENTIENDO EL FUNCIONAMIENTO EXACTO DE ESTE FRAGMENTO - INDAGAR MÁS EN ÉL**

## Clase 373
### Formulario para crear imágenes
- Primero actualizamos el enlace de "inicio" en app.blade.php: <a class="nav-link" href="{{route('home')}}">Inicio</a>.
- Luego crearemos el pack de controlador ruta y vista para IMAGEN
- **Controlador:** nos vamos a la consola y escribimos: **$ php artisan make:controller ImageController**.
- En este controlador, lo primero será restringir el acceso para usuarios no identificados con la función de la clase anterior
- Igualmente crearemos un método (create) que nos devolverá una vista del archivo image.create (vista)
- Creamos una carpeta image y dentro de esta un nuevo archivo para la vista -> create.blade.php; dentro de la carpeta views.
- **Ruta:** Antes de empezar a crear la vista crearemos la ruta para un facil acceso (nos dirigimos a web.php)-> **Route::get('/subir-imagen', [App\Http\Controllers\ImageController::class, 'create'])->name('imagen.create');
** || Igualmente añadimos la ruta al link de app.blade.php, en la parte de "Subir Imagen".
- **Vista:** Copiamos el contenido de config.blade.php (de la carpeta views/user) y editamos sobre este contenido
- En esta vista añadiremos un formulario para que el usuario pueda subir una imagen y su descripción:
- El código será el siguiente:
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card">
                <div class="card-header">Subir nueva imagen</div>
                <div class="card-body">
                    
                    <form action="" method="POST" enctype="multipart/form-data" >
                        @csrf
                        
                        <div class="form-group row mb-3">
                            <label for="image_path" class="col-md-3 col-form-label text-md-end">Imagen</label>
                            <div class="col-md-7">
                                <input id="image_path" type="file" name="image_path" class="form-control" required/>
                                
                                <!--Mostrar error en caso de fallo en la validación-->
                                @if($errors->has('image_path'))
                                    <span class='invalid-feedback' role='alert'>
                                        <strong>{{$errors->first('image_path')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="description" class="col-md-3 col-form-label text-md-end">Descripción</label>
                            <div class="col-md-7">
                                <textarea id="description" name="description" class="form-control" required></textarea>
                                
                                <!--Mostrar error en caso de fallo en la validación-->
                                @if($errors->has('description'))
                                    <span class='invalid-feedback' role='alert'>
                                        <strong>{{$errors->first('description')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
           
                            <div class="col-md-6 offset-md-3">
                                <input type='submit' class='btn btn-primary' value='Subir imagen'>
                                
                            </div>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
            
            
        </div>
    </div>
</div>
@endsection

```
## Clase 374
### Recibir datos del formulario anterior
- Primero crearemos un método para el action del formulario (save):
```html
public function save(Request $request) {
        var_dump($request);
        die();
    }
```
- Luego creamos la ruta en web.php para ver si el formulario llega correctamente: **Route::post('/image/save', [App\Http\Controllers\ImageController::class, 'save'])->name('image.save');**
- Añadimos esta nueva ruta al formulario se Subir imagen: **action="{{route('image.save')}}"**
- Probamos el formulario y vemos los resultados en el var_dump del método save. TODO OK.
- Rehacemos el método para guardar dichos datos en la BBDD (Completo y complejo):
```html
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
              
//        var_dump($image);
//        die();
        
        //Subir imagen a disco virtual de Laravel -> primero añadir: use Illuminate\Support\Facades\File; Y use Illuminate\Support\Facades\Storage;
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }
        
        // Guardar Obajeto Imagen en BBDD
        $image-> save();
        
        //Redirección a la ruta home
        return redirect()->route('home')->with([
           'message' => 'La Foto ha sido subida correctamente' 
        ]);
    }
```
- Por último al hacer que el redirect del método nos mande un mensaje flash, hay que editar el archivo resources/views/home.blade.php (página principal) para que nos muestre dicha alerta.
- Para ello creamos un archivo message en la carpeta includes dentro de views y lo completamos con el bloque de código para mostrar message que ya teníamos en config.blade.php (dentro de la carpeta user de views)
```html
@if(session('message'))
	<div class="alert alert-success">
		{{session('message')}}
	</div>
@endif
```
- Tras crear la vista dle include, añadiremos el código: **@include('includes.message')** donde queramos que aparezca dicho mensaje (en config.blade.php -sustituido- y en home.blade.php para cuando subamos imagen)

## Clase 375
### Listado de Imágenes - Preparando el backend
https://laravel.com/docs/11.x/eloquent#retrieving-models
- El listado de imágenes lo situaremos en la página principal, será necesario trabajar sobre el archivo App/Http/Controllers/HomeController.php
- Importamos **use App\Models\Image;**
- Procedemos a editar el método index para que, mediante el Eloquent ORM, mostremos todas las imágenes:
```html
    public function index()
    {
        $images = Image::orderBy('id', 'desc')->get(); //IMPORTANTE ESTA LÍNEA
        return view('home', [
            'images' => $images
        ]);
    }
```
### ACTUALIZACIÓN PERSONAL, STORAGE:LINK
En laravel 11 debemos hacer storage:link para hacer que las carpetas de storage puedan usarse de forma publica en la carpeta public:
https://kennyhorna.com/blog/file-storage-como-manejar-archivos-y-discos-en-laravel-0a85ea73-288d-4667-99f8-0f3d97c51a8d

-En primer lugar debemos editar el archivo filesystems.php haciendo que los nuevos discos creados (users e images) queden de la siguiente fomra:
```html
        'users' => [
            'driver' => 'local',
            'root' => storage_path('app/users'),
            'url' => env('APP_URL').'/avatares',
            'visibility' => 'public',
            'throw' => false,
        ],
        
        'images' => [
            'driver' => 'local',
            'root' => storage_path('app/images'),
            'url' => env('APP_URL').'/imagenes',
            'visibility' => 'public',
            'throw' => false,
```
- Y en el segundo apartado de links de este mismo archivo crear los enlaces simbólicos de la sigueinte forma teniendo en cuenta los nombres de url y las carpetas donde están almacenandos:
```html
    'links' => [
        public_path('avatares') => storage_path('app/users'),
        public_path('imagenes') => storage_path('app/images'),
    ],
```
- Luego en la consola de comandos ejecutamos: **php artisan storage:link**
- Esto creará dos carpetas (avatares e imagenes) donde se copiarán todos los archivos que se vayan subiendo mediante los métodos de inserción de imágenes.
- Es importante editar bien los enlaces en el home.blade.php para que se vean de manera correcta: (siguiente paso)
```html
<img src="avatares/{{$image->user->image}}" class="avatar"/>
<img src="imagenes/{{$image->image_path}}"/>
```

### Listado de Imágenes - Preparando el frontend
- Mediante un @foreach en home.blade.php mostraremos las diferentes imágenes que tengamos subidas:
```html
            @foreach ($images as $image)

            <div class="card pub-image">


                <div class="card-header">
                    
                    @if($image->user->image)
                        <div class='container-avatar'>
                            <img src="avatares/{{$image->user->image}}" class="avatar"/>
                        </div>
                    @endif
                    <div class="data-user">
                        {{ $image->user->name.' '.$image->user->surname.' | @'.$image->user->nick }}</div>
                    </div>
		</div>
                
                <div class="card-body">
			<div class="image-container">
                    		<!--<img src="{{route('image.file', ['filename' => $image->image_path])}}"/>-->
                       		<img src="imagenes/{{$image->image_path}}"/>
                         	<?php // var_dump($image->image_path); ?>
                    	</div>
                </div>    
            </div>
            @endforeach
```
## Clase 376
### Listado de Imágenes II - Preparando el frontend
- Hacemos una edición de css simple para mostrar mejor el nickname de los usuarios:
```html
(archivo home.blade.php)

<span class='nickname'>
	{{' | @'.$image->user->nick }}
</span>

-------------------------------------
(archivo style.css)

.pub-image{
    margin-bottom: 25px;
}

.pub-image .nickname{
    color: gray;
}
```
### INNECESARIO???????????????????????????
### Mostrar imágenes subidas y descripción
- Primero debemos hacer un método (en ImageController) que nos devuelva las imágenes del "Storage" que nos interesan
- Importamos **use Illuminate\Http\Response;**
- Creamos el método getImage:
```html
    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }
```
- Creamos la ruta en web.php para acceder al método: **Route::get('/image/file/{filename}', [App\Http\Controllers\ImageController::class, 'getImage'])->name('imagen.file');**
- Volvemos a home.blade.php y editamos el código, en la parte de class="card-body" para mostrar las imágenes

## Clase 377
### Paginación
- Nos dirigimos al método index del HomeController y cambiamos el get, por **paginate();**
- Ahora crearemos los links para ir navegando a través de la paginación realizada.
- En home.blade.php añadimos el siguiente código tras el @endforeach:
```html
@endforeach

            <!--PAGINACION-->
            <div class="clearfix"></div>
                {{$images->links()}}
```
Si da errores en cuanto a diseño, se puede cambiar por **simplePaginate** o dirigirnos a  App\Providers\AppServiceProvider:

```html
use Illuminate\Pagination\Paginator;
 
public function boot()
{
    Paginator::useBootstrap();
}
```
## Clase 378
### Maquetación de Comentarios y Likes
- Añadimos un botón para enlazar más tarde con los comentarios y le damos estilos.
- Para el contenedor de likes, buscaremos un icono de corazon en: https://www.iconsdb.com/black-icons/black-heart-icons.html
- Lo descargamos en formato png 64x64 tanto en gris como en rojo y los incluimos en una carpte "assets por ejemplo" dentro de la carpeta public.
- Lo mostramos mediante código y le damos estilos

El resultado del código y los estilos de esta clase serían los siguientes:
```html
CODIGO

<div class="likes">
	<img src="assets/heartgray.png" />
</div>

<div class="comments">
	<a href="" class="btn btn-sm btn-warning btn-comments">
		Comentarios
	</a>
</div>

----------------------------------------------------------
ESTILOS

.pub-image .description{
    padding: 20px;
    padding-bottom: 0px;
}

.pub-image .btn-comments{
    margin: 20px;
    margin-top: 0px;
    margin-left: 0px;
}

.likes{
    float: left;
    padding-left: 20px;
    padding-right: 10px;
}

.likes img{
    width: 20px;
}
```
## Clase 379
### Número de Comentarios
Añadiendo detrás de la palabra Comentarios "**{{count($image->comments)}}**" podemos mostrar el número de comentarios que tiene dicha foto.

## Clase 380
### Detalles de una imagen
Creamos el método "detail" dentro de ImageController. El cual, mediante un id pasado como parámetro nos retorna el objeto imagen completo usando **Image::find($id)**, y posteriormente nos devuelve una vista donde mostraremos dicha información.
```html
    public function detail($id) {
        $image = Image::find($id);
        
        return view('image.detail',[
            'image' => $image
        ]);
    }
```
- Ahora crearemos la vista image.detail (archivo detail.blade.php dentro de la carpeta image de views). Su contenido será simimlar al de home.blade.php pero elimnado el foreach y la paginación.
- A continuación creamos la ruta de esta nueva vista: **Route::get('/imagen/{id}', [App\Http\Controllers\ImageController::class, 'detail'])->name('image.detail');**
- En home.blade.php creamos un enlace para poder acceder a esta nueva vista mediante su ruta: **<a href="{{route('image.detail', ['id'=>$image->id])}}">**
- Si hay problemas, probar **$ php artisan route:clear** Para limpiar el cache de las rutas
- YO
- Yo, debido a errores anteriores con las imagenes en Storage, debo hacer cambios en los enlaces de las imágenes para que estas se vean correctamente y no dejen "pensando" el servidor para siempre.
- Para ello, he de añadir la ruta absoluta del vhost en cada imagen:
```html
<img src="http://proyecto-laravel.com.devel/avatares/{{$image->user->image}}" class="avatar"/>
<img src="http://proyecto-laravel.com.devel/imagenes/{{$image->image_path}}"/>
<img src="http://proyecto-laravel.com.devel/assets/heartgray.png" />
```
### IMPORTANTE
### Mejor hacer los enlaces usando: <img src="<?=env('APP_URL')?>/avatares/{{$image->user->image}}" class="avatar"/>
**<?=env('APP_URL')?>**
- (Siempre y cuando se haya rellenado el campo APP_URL en el archivo .env)
### IMPORTANTE
### Las llamadas a rutas pueden ser así o así:
```html
<a href="{{route('image.detail', ['id'=>$image->id])}}">
<a href="{{route('image.detail', $image->id)}}">
```
## Clase 381
### Formatear Fechas
- En primer lugar crearemos en home.blade.php el código para mostrar la fecha:
```html
<span class="nickname date">{{" | ".$image->created_at}}</span>
```
- Ahora vamos a darle formato a la fecha para que en vez de mostrarla tal cual, la muestre en modo: "subido hace X días"
- Para ello crearemos un helper que realice dicha función siguiendo el artículo de Victor RobleS: https://victorroblesweb.es/2018/01/18/crear-helpers-en-laravel-5/

### Creación de Helper
- Creamos carpeta Helpers dentro de la carpeta app
- Dentro creamos un archivo FromatTime.php
- Dentro definimos el namespace y cargamos la BBDD y copiamos el resto del Helper de la url anteriormente citada.
- xxxxxxxxxxx
- Luego tenemos que crear un provider https://laravel.com/docs/11.x/providers
- **php artisan make:provider FormatTimeServiceProvider**
- Si revisamos el provider (app/providers/nuestronuevoprovider) viene con la función boot y register
- xxxxxxxxxxx
- Dentro de register cargamos el helper para acceder a la nueva clase:
```html
public function register():void
{
    require_once app_path() . '/Helpers/FormatTime.php';
}
```
- Luego entramos en el directorio ∼config/app∼ bootstrap/providers (para laravel 11) y añadimos el array de providers si no está de manera automática: **App\Providers\FormatTimeServiceProvider::class,**
- Igualmente debemos añadir un alias de nuestro Helper. ∼En config/app Para laravel 5∼ . En Laravel 11 o usamos el helper directamente: **App\Helpers\FormatTime::LongTimeFilter($image->created_at)** O creamos un apartado en config/app.php tal que así:
- https://www.genspark.ai/spark/how-to-register-an-alias-in-laravel-11/86084fd5-6133-4fbf-954b-2491fe6d6b1b#adding-aliases-in-config%2Fapp.php-%5B2%5D
```html
use Illuminate\Support\Facades\Facade; //IMPORTANTE AÑADIR ESTA LÍNEA

(...)
(...)
(...)
(...)
(...)

/*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
	'FormatTime' => App\Helpers\FormatTime::class,
    ])->toArray(),
```
- Y así poder llamarlo sencillamente en cualquier parte de la aplicación: **\FormatTime::LongTimeFilter($image->created_at)**
### Otra opción por defecto (propio)
- https://laravel.com/docs/11.x/helpers#dates
- Carbon es un Provider que viene por defecto en laravel 11 que hace una función similar al provider creado por Victor Robles, el problema es que viene en inglés los String. Habría que modificarlos. Se usa de la siguinte manera: **\Carbon\Carbon::now()->diffForHumans($image->created_at)**

!!warning: in the working copy of 'bootstrap/providers.php', CRLF will be replaced by LF the next time Git touches it

## Clase 382
### Formulario de comentarios
(Un poco de maquetación de frontend)
- Creamos el formulario de comentarios dentro de detail.blade.php; bajo el h2 de Comentarios:
```html
                        <form action="" method="POST">
                            @csrf
                            <input type="hidden" name="image_id" value="{{$image->id}}"/>
                            <p>
                                <textarea class="form-control" name="content" required></textarea>
                            </p>
                            <button type="submit">
                                Enviar
                            </button>
                        </form>
```

## Clase 383
### Controlador de Comentarios
Como los comentarios son algo independiente de las imágenes y los Usuarios, crearemos un nuevo controlador para gestionar todo lo relacionado a ellos
- **php artisan make:controller CommentController**
- Accedemos al controlador de Comment (app/http/Controllers)
- Le añadimos el middleware básico de autenticación
```hmtl
    public function __construct(){
        $this->middleware('auth');
    }
```
- Y creamos un método para almacenar el contenido del formulario en la BBDD (save).
- Finalemnte creamos la ruta para este método y añadimos el action al formulario de detail.blade.php:
```html
RUTA:
Route::post('/comment/save', [App\Http\Controllers\CommentController::class, 'save'])->name('comment.save');
------------------------
ACTION:
<form action="{{route('comment.save')}}" method="POST">
```

### Validar Formulario de Comentarios
Viendo la documentación de Laravel11, encontramos un escritura de la validación más adecuada que la que emplea Victor Robles:
```html
NUEVA FORMA:
$validate = $request->validate([
            'image_id' => 'integrer|required',
            'content' => 'string|required',
        ]);
--------------------------------------------------
VICTOR ROBLES:
$validate = $this-> validate($request, [
            'image_id' => 'integrer|required',
            'content' => 'string|required',
        ]);
```
## Clase 384
### Mejora de la validación
Añadimos dentro del textaera del formulario de comentarios una ternaria para aplicar una clase adicional en caso de error:
```html
<textarea class="form-control {{$errors->has('content') ? 'is-invalid' : ''  }}" name="content"></textarea>
```
- Igualmente se han cambiado algunas cosas de creat.blade.php para que se muestren los inputs en rojo en caso de fallo en el require.


## Clase 385
### Guardar Comentarios en BBDD
Añadimos el objeto Comment a CommentController para poder instanciar objetos Comment: **use App\Models\Comment;**
- Completamos el método **save** con la agregación de valores al objeto, la subida a BBDD y la redirección:
```html
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
```
## Clase 386
### Listar Comentarios
No es necesario crear un nuevo método ya que el objeto $image dentro de la detail.blade.php ya tiene dentro los valores necesarios para acceder a los comentarios
- Después del formulario de comentarios añadimos:
```html
                        @foreach($image->comments as $comment)
                        <div class="comment">
                                <span class="nickname">{{'@'.$comment->user->nick}}</span>
                                <span class="nickname date">{{' | '. \FormatTime::LongTimeFilter($comment->created_at)}}</span>
                                <p>{{$comment->content}}</p>
                        </div>
                        @endforeach
```
## Clase 387
### Ordenar comentarios
Para hacer que se muestren de más nuevo a más antiguo debemos hacer una modificación en el model de Imagen:
- Añadimos orderBy al return del método comments:
```html
    public function comments(): HasMany {
        return $this->hasMany(Comment::class)->orderBy('id', 'desc');
    }
```
## Clase 388
### Eliminar Comentario (si se es dueño)
- Creamos el método delete dentro de CommentController
```html
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
```
- A continuación creamos la ruta en web.php: **Route::get('/comment/delete/{id}', [App\Http\Controllers\CommentController::class, 'delete'])->name('comment.delete');**
- Después crearemos un "link" en detail.blade.php para ejecutar la acción de borrar comentario; bajo la condición de que el usuario logged sea el dueño del propio comentario o el usuario sea el dueño de la imagen:
```html
<p>{{$comment->content}}<br>
                            
<!--Boton para borrar comentarios-->
<!--Es el mimso condicional que en CommentController-delete pero cambiando $user por Auth::check()-->
@if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
<a href="{{route('comment.delete', ['id' => $comment->id])}}" class="btn btn-sm btn-danger">
	Eliminar
</a>
@endif
</p>
```
## Clase 389
### Método Like
- Creamos el controlador de like por consola: **php artisan make:controller LikeController**
- Accedemos al controlador (app/http/controllers/LikController)
- Añadimos el middleware de autenticación
- Creamos el método like (pasando $image_id por parámetro):
```html
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
        }else{
            echo "ya existe el like";
        }
    }
```
- Creamos una ruta para este nuevo método: **Route::get('/like/{id}', [App\Http\Controllers\LikeController::class, 'like'])->name('like.save');**
- Seguimos modificando el método like; añadiremos un **return json**:
```html
        if ($isset_like == 0) {
            
		(...)

            return response()->json([
                'like' => $like
            ]);

        }else{

            return response()->json([
                'message' => 'El like ya existe'
            ]);
        }
```
## Clase 390
### Método Dislike
- Creamos el método dislike (pasando $image_id por parámetro); esta vez usamos el método "first" en la condición en vez de "count":
```html
    public function dislike($image_id) {
        //Recoger datos del usuario y de la imagen
        $user = \Auth::user();

        //Condición para que solo se pueda dar un like por persona a cada foto
        $like = Like::where('user_id', $user->id)
                ->where('image_id', $image_id)
                ->first(); 				//NOS PERMITE SACAR UN ÚNICO OBJETO DE LA BBD

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
```
- Creamos una ruta para este nuevo método: **Route::get('/dislike/{id}', [App\Http\Controllers\LikeController::class, 'dislike'])->name('like.delete');**
## Clase 391
### Detectar Likes
Modificamos el div de likes de home.blade.php -> añadimos clases e imagen complementaria (corazon rojo)
```html
                    <div class="likes">
			{{count($image->likes)}}
                        <img src="assets/heartgray.png" class="btn-like"/>
                        <img src="assets/heartred.png" class="btn-dislike"/>
                    </div>
```
- A continuación empleamos el detector de haber dado like o no a una publicación para mostrar un corazón u otro
```html
                    <div class="likes">
                        {{count($image->likes)}}

                        <!--Detector de likes del usuario logeado-->
                        <?php $user_like = false; ?>
                        
                        @foreach($image->likes as $like)
                            @if($like->user->id == Auth::user()->id)
                               <?php $user_like = true; ?> 
                            @endif
                        @endforeach
                        
                        @if($user_like)
                            <img src="assets/heartred.png" class="btn-dislike"/>
                        @else
                            <img src="assets/heartgray.png" class="btn-like"/>
                        @endif
                        
                    </div>
```
## Clase 392
### Funcionalidad AJAX alternar like/dislike
Añadiremos un archivo JS para incluir la funcionalidad de like/dislike
- Para ello debemos añadir el nuevo archivo en la carpeta public (de otro modo no sería aplicable para los usuarios).
- Creamos en la carpeta public un archivo "main.js"
- Rellenamos: 
```html
window.addEventListener("load", function(){
    alert("Página completamente carga");
});
```
- Cargamos esta prueba en nuestra pantilla principal; resources/views/layouts/app.blade.php
- Añadimos el script: **<script src="/js/main.js"></script>** (empleamos /js ya que esta dirigiendose a la carpeta del public)
- Al cargar la página nos sale un pop-up del alert que habíamos creado en el main.js

## Clase 393
### Comprobar JQUERY
- Cambiamos el código de main.js para ver si tenemos jquery instalado: **$('body').css('background', 'red');**
- En caso de que el color de fondo no cambie a rojo, significa que no está instalado. También podemos revisar la consola del navegador que nos dirá Uncaught error "$" o similar; significa que no está instalado jquery
- Para solucionar esto debemos ir nuevamente al archivo app.blade.php y añadir encima de nuestro script la siguiente línea: **    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>**
- Ahora debería cambiar el color y no dar mensajes de error en la consola del navegador
### Cambiar la Función del JS para Cabmiar Color del corazon al clicar
```html
//VICTOR ROBLES
window.addEventListener("load", function () {
//    alert("Página completamente carga");
//    COMPROBAR SI FUNCIONA JQUERY:
//    $('body').css('background', 'red');

    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

    //BOTON LIKE
    function like() {
        $('.btn-like').unbind('click').click(function () {
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', 'assets/heartred.png');
            dislike();
        });
    }
    like();

    //BOTON DISLIKE
    function dislike() {
        $('.btn-dislike').unbind('click').click(function () {
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', 'assets/heartgray.png');
            like();
        });
    }
    dislike();
});
```
## Clase 394
### Peticiones AJAX - guardar likes en BBDD
Antes de crear la función AJAX en main.js debemos hacer que el id de la imagen llegue al archivo main.js
- para ellos añadimos en home.blade.php el atributo data-id="{{$image->id}}" a las diferentes imágenes para que pueda ser leído por main.js y trabajar con ello
- Y modificamos el archivo main.js (añadimos una variable "url" en el incio -que habría que cambiar al finalizar el pryecto en base al dominio- y las funciones ajax):
```html
//VICTOR ROBLES
var url ='http://proyecto-laravel.com.devel/';
window.addEventListener("load", function () {
//    alert("Página completamente carga");
//    COMPROBAR SI FUNCIONA JQUERY:
//    $('body').css('background', 'red');

    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

    //BOTON LIKE
    function like() {
        $('.btn-like').unbind('click').click(function () {
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', 'assets/heartred.png');
            
            $.ajax({
                url: url+'like/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                      console.log('Has dado like');  
                    }else{
                        console.log('Error al dar like'); 
                    }
                }
            });
            
            dislike();
        });
    }
    like();

    //BOTON DISLIKE
    function dislike() {
        $('.btn-dislike').unbind('click').click(function () {
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', 'assets/heartgray.png');
            
                        $.ajax({
                url: url+'dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                      console.log('Has dado dislike');  
                    }else{
                        console.log('Error al dar dislike'); 
                    }
                }
            });
            
            like();
        });
    }
    dislike();
});
```
## Clase 395
### Funciones AJAX para la parte detail
Copiamos el bloque likes de home.blade.php y lo pegamos en detail.blade.php sustituyendo los enlaces de las imágenes para evitar que den error: 
```html
<?= env('APP_URL') ?>/
```
```html
@if($user_like)
	<img src="<?= env('APP_URL') ?>/assets/heartred.png" data-id="{{$image->id}}" class="btn-dislike"/>
@else
	<img src="<?= env('APP_URL') ?>/assets/heartgray.png" data-id="{{$image->id}}" class="btn-like"/>
@endif
```

- En main.js también debemos hace un cambio; debemos añadir "url+" delante de las rutas del src de cada función
```html
(...)
$(this).attr('src', url+'/assets/heartred.png');
(...)
$(this).attr('src', url+'/assets/heartgray.png');
(...)
```
## Clase 396
### Listar Publicaciones a las que hemos dado Like
- Creamos un nuevo método "index" en LikeController; muy similar al método "index" de HomeController
- Revisamos que esté importado el modelo Like en el Controlador: **use App\Models\Like;**
- Modificamos los nombres de las variables, el objeto Like::orderBy y el nombre de una nueva vista que crearemos a continuación:
```html
    public function index() {
        $likes = Like::orderBy('id', 'desc')->paginate(5);
        return view('like.index', [
            'likes' => $likes
        ]);
    }
```
- Creamos la vista like.index (resources/views/like/index.blade.php) -> de momento con un h1 para ver si funciona
- Creamos la ruta en web.php: **Route::get('/likes', [App\Http\Controllers\LikeController::class, 'index'])->name('likes');**
- Optimizamos la consulta de LikeController::index ya que con el método actual estamso sacando todos los likes de la BBDD y solo queremos los del usuario autenticado
```html
    public function index() {
        $user = \Auth::user();
        $likes = Like::where('user_id' , $user->id)
                ->orderBy('id', 'desc')
                ->paginate(5);
        return view('like.index', [
            'likes' => $likes
        ]);
    }
```
- Ahora modificamos el index.blade.php de like. Copiaremos la estructura de home.blade.php y trabajaremos sobre ella.
- Victor se molesta en hacer un nuevo include (images) para el bloque de dentro del foreach de home.blade.php y reutilizarlo en index.blade.php y en la propia home.blade.php
```html
@include('includes.image', ['image' => $image]) // PARA HOME.BLADE.PHP
@include('includes.image', ['image' => $like->image]) // PARA INDEX.BLADE.PHP -> porque en el modelo de like tenemos el método image
---------------------------------------
<!--PAGINACION-->
<div class="clearfix"></div>
{{$likes->links()}}
```
## Clase 397
### Entrada del Menú para acceder a Favoritas
Abrimos app.blade.php en layouts
- Añadimos un nuevo <li> al menú superior y cambiamos la ruta a la que dirige y el texto:
```html
<li class="nav-item">
	<a class="nav-link" href="{{route('likes')}}">
		Favoritas
	</a>
</li>
```
## Clase 398
### Perfil de Usuario
- Cargamos el modelo User en UserController: **use App\Models\User;** ya que vamos a necesitarlo
- Creamos un método "profile" dentro de UserController
```html
    public function profile($id) {
        $user = User::find($id);
        
        return view('user.profile', [
            'user' => $user
        ]);
    }
```
- Creamos la vista a la que retorna dicho método **(resources/views/user/profile.blade.php)**-> h1 de pruebas
- Creamos la ruta en web.php: **Route::get('/perfil/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');**
- Cambiamos el href de "Mi perfil" en app.blade.php
```html
<a class="dropdown-item" href="{{ route('profile' , ['id' => Auth::user()->id]) }}">
	Mi perfil
</a>
```
- Editamos la vista profile.blade.php
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Mi perfil</h1>
            <hr/>
            
            @foreach ($user->images as $image)
                @include('includes.image', ['image' => $image])           
            @endforeach

        </div>        
    </div>
</div>
@endsection
```

## Clase 399
### Mostrar datos en el perfil
Editamos el archivo profile.blade.php
- En el primer bloque, si copiamos de image.blade.php, debemos tener en cuenta que el @if no debe ser de $image->user->image; sino $user->image
- Y así con el resto de variables de laravel (las que van entre dos corchetes) **ATENCION A ESTO**
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="data-user">
                
                @if($user->image)
                    <div class='container-avatar'>
                        <img src="<?= env('APP_URL') ?>/avatares/{{$user->image}}" class="avatar"/>
                    </div>
                @endif
                
                <div class="user-info">
                    <h1>{{'@'.$user->nick}}</h1>
                    <h2>{{$user->name.' '.$user->surname}}</h2>
                    <p><span class="nickname date">{{'Se unió: '. \FormatTime::LongTimeFilter($user->created_at)}}</span></p>
                </div>
                
            </div>

            @foreach ($user->images as $image)
            @include('includes.image', ['image' => $image])           
            @endforeach

        </div>        
    </div>
</div>
@endsection
```
## Clase 400
### Maquetación Perfil Usuario
Añadimos estilos a las clases de profile.blade.php y añadimos algunos contenedores para organizar el contenido

## Clase 401
### Botones para Eliminar y editar publicaciones si son del usuario registrado
- Nos dirigimos al archivo detail.blade.php
- Añadimos bajo los comentarios un nuevo contenedor de Botones para incluir el boton de eliminar y editar
```html
<!--BOTONES DE ELIMINAR Y EDITAR-->
@if(Auth::user() && Auth::user()->id == $image->user->id)
	<div class="actions">
		<a href="" class="btn btn-sm btn-primary">Actualziar</a>
		<a href="" class="btn btn-sm btn-danger">Borrar</a>
	</div>
@endif
```
## Clase 402
### Botón de Borrar, función
- Nos dirigimos al controlador de Imagen y añadimos los modelos de comentarios y like, también debemos tener cargado el objeto Storage (previamente hehco)
```html
use App\Models\Comment;
use App\Models\Like;
```
- Creamos el nuevo método delete, teniendo en cuenta que tendremos que borrar los comentarios y likes asociados a la imagen antes de elimnar la imagen para evitar errorres de integridad referencial
```html
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
            Storage::disk('images')-> delete($image->image_path);
            
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
```
- A continuación crearemos la ruta del método delete de ImageController en web.php: **Route::get('/image/delete/{id}', [App\Http\Controllers\ImageController::class, 'delete'])->name('image.delete');**
- Añadimos esta ruta al botón de borrar de la vista detail.blade.php:
```html
<a href="{{route('image.delete', ['id'=>$image->id])}}" class="btn btn-sm btn-danger">Borrar</a>

```
**INTERESANTE VER LAS OTRAS SOLUCIONES QUE HAN DADO LOS COMPAÑEROS EN LOS COMENTARIOS DE ESTA CLASE** -> https://www.udemy.com/course/master-en-php-sql-poo-mvc-laravel-symfony-4-wordpress/learn/lecture/11934500#questions/8574908
## Clase 403
### Modal de Bootstrap 4 -> Confirmación de borrado
https://www.w3schools.com/bootstrap/bootstrap_modal.asp
- Copiamos el código del modal para que aparezca un pop-up y confirmar la acción de borrado
- Lo añadimos a detail.blade.php y editamos a nuestro gusto
- Para que el modal se muestre, debemos incluir el siguiente código en la parte de scripts de app.blade.php
```html
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
```
- Editamos el código del modal:
```html
<!--MODAL DE BOOTSTRAP PARA BORRAR IMAGEN-->
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal">
                            Borrar
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Borrar Imagen</h5>
                                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>-->
                                    </div>
                                    <div class="modal-body">
                                        <p>Estás a punto de borrar esta imagen, sus comentarios y sus likes ¿Estás seguro de que quieres continuar?</p>
                                        <p> No habrá marcha atrás</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <a href="{{route('image.delete', ['id'=>$image->id])}}" class="btn btn-danger">Borrar Definitivamente</a>

                                    </div>
                                </div>
                            </div>
```
## Clase 404
### Formulario actualización de imágenes
- Creamos el método edit para redirigir a una nueva vista ('image.edit')
```html
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
            
        }else{
            //Redirección Fail
            return redirect()->route('home');
        }   
    }
```
- Creamos la vista edit.blade.php dentro de la carpeta image -> h1 de prueba
- Creamos la ruta correspondiente: **Route::get('/imagen/editar/{id}', [App\Http\Controllers\ImageController::class, 'edit'])->name('image.edit');**
- Insertamos la ruta en el link de Actualizar de detial.blade.php
```html
<a href="{{route('image.edit', ['id'=> $image->id])}}" class="btn btn-sm btn-primary">Actualziar</a>

```
### Vista edit.blade.php
Copiamos el contenido de create.blade.php y lo modificamos
- Cambiamos el título de la "card"
- Cambiamos (de momento eliminamos) el action del formulario, ya que emplearemos otro método diferente
- Añadimos una pequeña vista para mostrar la imagen || o un enlace en mi caso
- Cambiamos el value del botón submit ("Actualizar Imagen")
- Rellenamos los campos del formulario con los datos del objeto que pasamos a través del método edit del ImageController:
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Editar mi imagen</div>
                <div class="card-body">

                    <form action="" method="POST" enctype="multipart/form-data" >
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="image_path" class="col-md-3 col-form-label text-md-end">Imagen</label>
                            <div class="col-md-7">

                                @if($image->user->image)
                                <div class='container-avatar'>
                                    <img src="<?= env('APP_URL') ?>/avatares/{{$image->user->image}}" class="avatar"/>
                                </div>
                                @endif

                                <input id="image_path" type="file" name="image_path" class="form-control  {{$errors->has('image_path') ? 'is-invalid' : ''  }}"/>

                                <!--Mostrar error en caso de fallo en la validación-->
                                @if($errors->has('image_path'))
                                <span class='invalid-feedback' role='alert'>
                                    <strong>{{$errors->first('image_path')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="description" class="col-md-3 col-form-label text-md-end">Descripción</label>
                            <div class="col-md-7">
                                <textarea id="description" name="description" class="form-control {{$errors->has('description') ? 'is-invalid' : ''  }}">{{$image->description}}</textarea>

                                <!--Mostrar error en caso de fallo en la validación-->
                                @if($errors->has('description'))
                                <span class='invalid-feedback' role='alert'>
                                    <strong>{{$errors->first('description')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">

                            <div class="col-md-6 offset-md-3">
                                <input type='submit' class='btn btn-primary' value='Actualizar imagen'>

                            </div>
                        </div>

                    </form>

                </div>
            </div>


        </div>
    </div>
</div>
@endsection
```
## Clase 405
### Método para actualziar imagen
- Añadimos un bloque nuevo para mostrar una miniatura de la imagen a modificar
```html
<img src="<?= env('APP_URL') ?>/imagenes/{{$image->image_path}}" class="avatar"/>
```
- Creamos un input hidden en edit.blade.php para poder pasar el id de la imagen
```html
<input type="hidden" name="image_id" value="{{$image->id}}"/>

```
- Creamos nuevo método en ImageController: update -> iremos modificándolo
- Creamos la ruta para este método: **Route::post('/image/update', [App\Http\Controllers\ImageController::class, 'update'])->name('image.update');** 
- Añadimos la ruta al action del formulario:
```html
<form action="{{route('image.update')}}" method="POST" enctype="multipart/form-data" >
```
## Clase 406
### Página de gente
- Creamos el método "index" en UserController
```html
public function index(){
        $users = User::orderBy('id','desc')->paginate(5);
        return view('user.index',[
            'users' => $users
        ]);
    }
```
- Creamos la vista user/index.blade.php
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @foreach ($users as $user)

                @if($user->image)
                    <div class='container-avatar'>
                        <img src="<?= env('APP_URL') ?>/avatares/{{$user->image}}" class="avatar"/>
                    </div>
                @endif

                <div class="user-info">
                    <h1>{{'@'.$user->nick}}</h1>
                    <h2>{{$user->name.' '.$user->surname}}</h2>
                    <p><span class="nickname date">{{'Se unió: '. \FormatTime::LongTimeFilter($user->created_at)}}</span></p>
                </div>

            @endforeach

            <!--PAGINACION-->
            <div class="clearfix"></div>
            {{$users->links()}}

        </div>        
    </div>
</div>
@endsection
```
- Creamos la ruta en web.php: **Route::get('/gente', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');**
- Creamos un nuevo apartado en app.blade.php -> "gente"
```html
<li class="nav-item">
	<a class="nav-link" href="{{route('user.index')}}">
		Gente
	</a>
</li>
```






















