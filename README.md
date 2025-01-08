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
