UD3 Ejercicios

Ejercicio 1: Crear Repositorio GitHub

Objetivo
Crear un repositorio en GitHub llamado "ud3_ejercicios" y dar acceso al usuario jpaniorte.

Pasos Realizados
1. Inicié sesión en GitHub
2. Creé un nuevo repositorio llamado "ud3_ejercicios"
3. Añadí al usuario jpaniorte como colaborador del repositorio

Ejercicio 2: Crear Proyecto Laravel

Objetivo
Clonar el repositorio y crear un nuevo proyecto Laravel 11.x con las opciones "No starter kit" y "PHPUnit".

Pasos Realizados
1. Cloné el repositorio:

git clone https://github.com/[mi-usuario]/ud3_ejercicios.git
cd ud3_ejercicios


2. Creé un nuevo proyecto Laravel:

composer create-project laravel/laravel:^11.0 .


3. Realicé el commit inicial:

git add .
git commit -m "Hello World ejercicios UD3"


Problemas Encontrados y Soluciones

1. Error al hacer push al repositorio
   - Problema: El repositorio remoto no estaba configurado correctamente
   - Solución: Añadí el repositorio remoto y configuré la rama principal

   git remote add origin https://github.com/[mi-usuario]/ud3_ejercicios.git
   git branch -M main
   git push -u origin main


2. Opciones de instalación no visibles
   - Problema: No aparecieron las opciones para seleccionar "No starter kit" y "PHPUnit"
   - Solución: Laravel 11 ya incluye estas configuraciones por defecto:
     - No incluye ningún starter kit por defecto
     - PHPUnit viene instalado por defecto

Verificación
- Repositorio creado y accesible en GitHub
- Proyecto Laravel 11 instalado correctamente
- Archivos subidos exitosamente al repositorio


Ejercicio 3: Configuración de MariaDB con Docker

Objetivo
Configurar un servidor de base de datos MariaDB usando Docker con los siguientes parámetros:
- Nombre: mariadb-server
- Puerto: 3307 (modificado del 3306 debido a problemas de permisos)
- Usuario: root
- Contraseña: m1_s3cr3t

Pasos Realizados

1. Creación del archivo Dockerfile con la siguiente configuración:

FROM mariadb:latest
ENV MYSQL_ROOT_PASSWORD=m1_s3cr3t
ENV MYSQL_DATABASE=test1
EXPOSE 3306


2. Construcción de la imagen Docker:

docker build -t mariadb-server .


3. Ejecución del contenedor:

docker run -d --name mariadb-server -p 3307:3306 mariadb-server


Problemas Encontrados y Soluciones

1. Error de TTY en Windows/Git Bash
   - Problema: No se podía ejecutar el comando `docker exec` debido a error de TTY
   - Solución: Se añadió el prefijo 'winpty' al comando

   winpty docker exec -it mariadb-server mariadb -u root -p


2. Problema de Permisos en Puerto 3306
   - Problema: No se podía vincular al puerto 3306 por problemas de permisos
   - Solución: Se utilizó el puerto 3307 en su lugar

   docker run -d --name mariadb-server -p 3307:3306 mariadb-server


Verificación
Se logró conectar a la base de datos y ejecutar los comandos de prueba:

CREATE DATABASE test1;
SHOW DATABASES;



Ejercicio 4 - Análisis de Archivos de Migración

Preguntas y Respuestas

1. ¿Qué crees que hace el método create de la clase Schema?
   - El método Schema::create se utiliza para crear nuevas tablas en la base de datos. Acepta dos parámetros:
     - El nombre de la tabla que se va a crear
     - Una función closure que utiliza la clase Blueprint para definir la estructura de la tabla
   - Este método es fundamental para definir la estructura de la base de datos en las migraciones de Laravel.

2. ¿Qué crees que hace $table->string('email')->primary();?
   - Esta línea de código realiza dos operaciones:
     - Crea una columna llamada 'email' con tipo de dato VARCHAR (string en Laravel)
     - Establece esta columna como la clave primaria de la tabla
   - El modificador primary() asegura que la columna será única e indexada

3. ¿Cuántas tablas hay definidas? Indica el nombre de cada tabla
   - Hay 8 tablas definidas en los archivos de migración:
     1. users
     2. password_reset_tokens
     3. sessions
     4. cache
     5. cache_locks
     6. jobs
     7. job_batches
     8. failed_jobs



Ejercicio 5 - Configuración de Base de Datos y Migración

Proceso de Configuración

1. Creación del contenedor Docker para MariaDB:

docker run --name mariadb-server -e MYSQL_ROOT_PASSWORD=m1_s3cr3t -p 3307:3306 -d mariadb:latest


2. Modificación del archivo .env de Laravel:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=test1
DB_USERNAME=root
DB_PASSWORD=m1_s3cr3t


3. Configuración de la base de datos y permisos:

CREATE DATABASE IF NOT EXISTS test1;
CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY 'm1_s3cr3t';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;


Problemas Encontrados y Soluciones

1. Problema de Acceso al Puerto
   - Problema: Inicialmente se encontró acceso denegado al puerto 3306
   - Solución: Cambio al puerto 3307 para el contenedor Docker

2. Error de Conexión a la Base de Datos
   - Problema: Laravel no podía conectarse a MariaDB
   - Solución: 
     - Actualización del archivo .env con el puerto correcto (3307)
     - Otorgamiento de permisos adecuados al usuario root
     - Limpieza de la caché de configuración de Laravel

3. Resultados de la Migración
   - Se crearon exitosamente 9 tablas en la base de datos test1:
     1. cache
     2. cache_locks
     3. failed_jobs
     4. job_batches
     5. jobs
     6. migrations
     7. password_reset_tokens
     8. sessions
     9. users




Ejercicio 6 - Explicación de Comandos de Migración de Laravel

 `php artisan migrate`
Este comando ejecuta todas las migraciones pendientes. Se encarga de ejecutar todos los archivos de migración en el directorio `database/migrations` que aún no se han ejecutado. Se utiliza para crear nuevas tablas o modificar las existentes en la base de datos.

 `php artisan migrate:status`
Este comando muestra el estado actual de cada archivo de migración, indicando si se ha ejecutado o no. Proporciona una tabla que muestra el nombre de la migración, el número de lote y si ha sido ejecutada.

 `php artisan migrate:rollback`
Este comando revierte el último lote de migraciones. Si ejecutaste varias migraciones a la vez, esto deshará todas ellas. Ejecuta el método `down()` en cada archivo de migración del último lote.

 `php artisan migrate:reset`
Este comando revierte todas las migraciones que se han ejecutado, efectivamente vaciando tu base de datos de todas las tablas creadas a través de migraciones. Ejecuta el método `down()` de cada migración desde la más reciente hasta la más antigua.

 `php artisan migrate:refresh`
Este comando combina `migrate:reset` y `migrate` - revertirá todas las migraciones y luego las ejecutará todas de nuevo. Es útil cuando quieres empezar con una base de datos limpia mientras mantienes tu esquema.

 `php artisan make:migration`
Este comando crea un nuevo archivo de migración en el directorio `database/migrations`. Típicamente se añade un nombre descriptivo, como: `php artisan make:migration crear_tabla_usuarios`. Laravel añadirá automáticamente una marca de tiempo al nombre del archivo.

 `php artisan migrate --seed`
Este comando ejecuta todas las migraciones pendientes y luego ejecuta los seeders de la base de datos. Los seeders se utilizan para poblar tu base de datos con datos de prueba o datos iniciales. La bandera `--seed` le dice a Laravel que ejecute la clase `DatabaseSeeder` después de que las migraciones se completen.


Ejercicio 7 -

Requisitos del Ejercicio
Crear la base de datos test2 y conectar la aplicación a dicha base de datos. Emplear el comando `php artisan make:migration my_test_migration` para crear el fichero `database/migrations/<timestamp>_my_test_migration.php`. El archivo contiene dos métodos: `up()` y `down()`.

Pasos de Implementación

1. Creación de la base de datos test2:

docker exec -it mariadb-server mariadb -u root -p
CREATE DATABASE IF NOT EXISTS test2;


2. Modificación de la configuración de la base de datos en .env:

sed -i 's/DB_DATABASE=.*/DB_DATABASE=test2/' .env
sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=m1_s3cr3t/' .env
sed -i 's/DB_HOST=.*/DB_HOST=127.0.0.1/' .env
sed -i 's/DB_PORT=.*/DB_PORT=3307/' .env
sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=mariadb/' .env


3. Creación del archivo de migración:

php artisan make:migration my_test_migration


4. Adición de la estructura de la tabla en el archivo de migración:

// En el método up()
Schema::create('alumnos', function (Blueprint $table) {
    $table->id(); 
    $table->string('nombre'); 
    $table->string('email')->unique(); 
    $table->timestamps(); 
});

// En el método down()
Schema::dropIfExists('alumnos');


5. Ejecución de la migración:

php artisan migrate


Problemas Encontrados y Soluciones

Problema 1: Error de Conexión a la Base de Datos
Inicialmente se encontró el error "Access denied for user 'root'@'localhost'".

Solución:
Se agregaron los privilegios necesarios al usuario root:

GRANT ALL PRIVILEGES ON test2.* TO 'root'@'%' IDENTIFIED BY 'm1_s3cr3t';
GRANT ALL PRIVILEGES ON test2.* TO 'root'@'localhost' IDENTIFIED BY 'm1_s3cr3t';
FLUSH PRIVILEGES;


Problema 2: Configuración Incorrecta del Puerto
La conexión a la base de datos falló porque el contenedor de MariaDB estaba usando el puerto 3307 en lugar del 3306.

Solución:
Se actualizó el DB_PORT en .env para que coincida con el puerto del contenedor:

sed -i 's/DB_PORT=.*/DB_PORT=3307/' .env


Verificación
Se verificó exitosamente la creación de la tabla:

USE test2;
SHOW TABLES;

La salida mostró la tabla 'alumnos' junto con otras tablas predeterminadas de Laravel, confirmando la implementación exitosa.

Comprensión del Código de Migración

La migración crea una tabla con la siguiente estructura:
- `id`: Clave primaria auto-incrementable
- `nombre`: Columna de tipo string para almacenar nombres
- `email`: Columna de tipo string única para almacenar direcciones de correo electrónico
- `timestamps`: Crea las columnas `created_at` y `updated_at`

El método `down()` asegura la eliminación limpia de la tabla si es necesario, permitiendo migraciones reversibles.

Respuestas a las Preguntas del Ejercicio

¿Qué hace el método `create` de la clase Schema?
El método `create` en la clase Schema se utiliza para crear una nueva tabla en la base de datos. Este método toma dos parámetros: el nombre de la tabla que se va a crear y una función de callback que define la estructura de la tabla utilizando el objeto Blueprint.

¿Qué hace `$table->string('email')->unique()`?
Esta línea de código realiza dos acciones:
1. `string('email')`: Define una columna llamada "email" de tipo VARCHAR en la base de datos
2. `->unique()`: Añade una restricción UNIQUE a la columna, asegurando que no puedan existir dos registros con el mismo valor de email

¿Cuántas tablas hay definidas?
Después de ejecutar las migraciones, se crearon las siguientes tablas:
- alumnos
- cache
- cache_locks
- failed_jobs
- job_batches
- jobs
- migrations
- password_reset_tokens
- sessions
- users

En total, hay 10 tablas definidas en la base de datos test2




Ejercicio 8: Añadir Campo 'apellido' a la Tabla Alumnos

Pregunta del Ejercicio
¿Qué pasos debemos dar si queremos añadir el campo $table->string('apellido'); a la tabla alumnos del ejercicio anterior?

Procedimiento de Solución

1. Creación de la Migración
Primero, creé una nueva migración específica para añadir el campo 'apellido':
bash
php artisan make:migration add_apellido_to_alumnos_table --table=alumnos


2. Configuración de la Migración
La migración se creó en el archivo database/migrations/[timestamp]_add_apellido_to_alumnos_table.php con la siguiente estructura:

php
public function up()
{
    Schema::table('alumnos', function (Blueprint $table) {
        $table->string('apellido')->after('nombre')->nullable();
    });
}

public function down()
{
    Schema::table('alumnos', function (Blueprint $table) {
        $table->dropColumn('apellido');
    });
}


3. Ejecución de la Migración
bash
php artisan migrate


Problemas Encontrados y Soluciones

Problema 1: Error de Sintaxis
Al crear la migración inicialmente, encontré un error de sintaxis en el método up():

Error:

ParseError: syntax error, unexpected token "{"


Causa:
El error se produjo porque había tanto un dos puntos : como una llave { después de la declaración del método up().

Solución:
Se corrigió eliminando el dos puntos : después de up(), dejando solo la llave {.

Explicación de la Solución Final
1. La migración utiliza el método Schema::table() para modificar una tabla existente.
2. Se añade el campo 'apellido' como una cadena de texto (VARCHAR en la base de datos).
3. El modificador ->after('nombre') coloca el nuevo campo después del campo 'nombre'.
4. El modificador ->nullable() permite que el campo pueda estar vacío, lo cual es necesario ya que los registros existentes no tendrán este dato.
5. En caso de necesitar revertir los cambios, el método down() eliminará la columna usando dropColumn().

Verificación
Para verificar que el campo se añadió correctamente, se puede usar el siguiente comando:
sql
DESCRIBE alumnos;


Este ejercicio demuestra cómo Laravel permite modificar la estructura de la base de datos de manera segura y reversible mediante el sistema de migraciones.





Ejercicio 9 - Seeders en Laravel

Objetivo del Ejercicio
Crear datos de prueba para la tabla `alumnos` utilizando los Seeders de Laravel.

Pasos Realizados

1. Creación del Seeder

php artisan make:seeder AlumnosTableSeeder


2. Modificación del archivo AlumnosTableSeeder.php
- Ubicación: `database/seeders/AlumnosTableSeeder.php`
- Se añadió el código necesario para insertar tres alumnos de prueba
- Se importaron las clases necesarias:
  - Illuminate\Support\Facades\DB
  - Carbon\Carbon

3. Actualización del DatabaseSeeder.php
- Ubicación: `database/seeders/DatabaseSeeder.php`
- Se añadió la llamada al AlumnosTableSeeder

4. Ejecución del Seeder

php artisan db:seed


Problemas Encontrados y Soluciones

Problema 1: Class "Database\Seeders\DB" not found
- Descripción: Al ejecutar el seeder, Laravel no podía encontrar la clase DB
- Causa: Faltaba importar la clase DB en el archivo AlumnosTableSeeder.php
- Solución: Se añadió la línea `use Illuminate\Support\Facades\DB;` al inicio del archivo

Verificación de Datos

Para verificar que los datos se insertaron correctamente:


docker exec -it mariadb-server mariadb -u root -p
USE test2;
SELECT * FROM alumnos;


Los datos insertados fueron:
1. Juan Pérez (juan.perez@example.com)
2. María González (maria.gonzalez@example.com)
3. Carlos López (carlos.lopez@example.com)

Conceptos Clave Aprendidos

1. Los Seeders son una herramienta fundamental en Laravel para crear datos de prueba
2. Es importante importar todas las clases necesarias (DB, Carbon) en los archivos de Seeder
3. La estructura del proyecto debe mantenerse organizada siguiendo las convenciones de Laravel
4. El comando `php artisan db:seed` ejecuta todos los seeders registrados en DatabaseSeeder.php

Conclusión
El ejercicio se completó exitosamente, logrando crear y poblar la tabla de alumnos con datos de prueba utilizando los Seeders de Laravel. Esta práctica es fundamental para el desarrollo y prueba de aplicaciones, ya que permite tener datos consistentes para realizar pruebas.




Ejercicio 10 - Sistema de Gestión de Notas

Objetivo del Ejercicio
Implementar un sistema para gestionar las notas de los alumnos en diferentes asignaturas según el siguiente diagrama E-R proporcionado:

Pasos Realizados

1. Creación de Migraciones
Se crearon tres migraciones principales para implementar el diagrama E-R:
- Tabla alumnos (ya existente de ejercicios anteriores)
- Tabla asignaturas (nueva)
- Tabla notas (nueva)

Comandos utilizados:

php artisan make:migration create_asignaturas_table
php artisan make:migration create_notas_table

2. Problemas Encontrados y Soluciones
Problema 1: Conflicto con Tabla Existente

Problema: Al intentar crear la tabla 'alumnos', surgió un error porque ya existía una migración previa que la creaba.
Solución: Se modificó la nueva migración para incluir una verificación de existencia de la tabla:

phpCopyif (!Schema::hasTable('alumnos')) {
    Schema::create('alumnos', function (Blueprint $table) {
        // ...
    });
}

3. Estructura Final de las Tablas
Tabla Alumnos
id (PK)
nombre
email (único)
timestamps

Tabla Asignaturas
id (PK)
nombre
descripcion
timestamps

Tabla Notas
id (PK)
alumno_id (FK)
asignatura_id (FK)
nota
timestamps

4. Seeders para Datos de Prueba
Se crearon seeders para poblar la base de datos con datos de ejemplo:

AlumnosTableSeeder
AsignaturasTableSeeder
NotasTableSeeder

Verificación y Pruebas
Se ejecutaron las migraciones con php artisan migrate:fresh --seed
Se verificó la estructura correcta de las tablas
Se comprobó la integridad referencial entre las tablas

Respuestas a las Preguntas del Ejercicio:
¿Qué hace el método create de la clase Schema?
El método create se utiliza para crear nuevas tablas en la base de datos, definiendo su estructura y atributos.

¿Qué hace $table->string('email')->unique();?
Esta línea crea una columna de tipo string llamada 'email' y la marca como única, asegurando que no pueda haber valores duplicados.

¿Cuántas tablas hay definidas en el sistema final?
El sistema cuenta con tres tablas principales:
alumnos
asignaturas
notas

