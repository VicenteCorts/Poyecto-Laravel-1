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
Elocuent - modelo de programación cuya misión es transformar las tablas de una base de datos de forma que las tareas básicas, que realizan los programadores, estén simplificadas-
- **En symfony es Doctrine**
### Ubicación
Los modelos se crean dentro de la carpeta app>models
- nos vamos a la consola, a la carpeta del proyecto
- $ php artisan make:model "nombre-del-modelo"
- Los modelos se guardan en Mayus y singular Imagen, Like, Comentario, etc...



