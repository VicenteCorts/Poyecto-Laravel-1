npm# PROYECTO LARAVEL - INSTAGRAM
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


















