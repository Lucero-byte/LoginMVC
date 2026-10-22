# Conexión a MySQL / MariaDB

## 1. Qué base de datos usa el sistema

- **Base de datos:** `login_mvc`
- **Tabla:** `usuarios`
- **Usuario de MySQL:** `root`
- **Contraseña:** vacía (configuración por defecto de XAMPP)
- **Host:** `127.0.0.1`
- **Puerto:** `3307` (MySQL/MariaDB de XAMPP en este equipo)

La conexión está en:

```
config/database.php
```

Y el script para crear todo está en:

```
database/usuarios.sql
```

## 2. Cómo importar la base de datos

### Opción A: desde phpMyAdmin

1. Abre el panel de XAMPP y asegúrate de que **MySQL** esté iniciado.
2. Entra a `http://localhost/phpmyadmin`.
3. Ve a la pestaña **Importar**.
4. Selecciona el archivo `database/usuarios.sql`.
5. Presiona **Continuar**.

### Opción B: desde la terminal (PowerShell)

```powershell
Get-Content -Raw "C:\xampp\htdocs\LoginModeloVistaControlador\database\usuarios.sql" |
    & "C:\xampp\mysql\bin\mysql.exe" -h 127.0.0.1 -P 3307 -u root
```

Si tu MySQL escucha en el puerto `3306`, cambia `-P 3307` por `-P 3306`.

## 3. Cómo cambiar los datos de conexión

Edita `config/database.php`. Los valores por defecto son:

```php
$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3307';
$name = getenv('DB_NAME') ?: 'login_mvc';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
```

También puedes definirlos como variables de entorno antes de iniciar Apache/PHP:

```text
DB_HOST=127.0.0.1
DB_PORT=3307
DB_NAME=login_mvc
DB_USER=root
DB_PASS=
```

> Si usas el MySQL instalado aparte (puerto 3306), cambia `DB_PORT` a `3306`
> y coloca la contraseña real de tu usuario `root`.

## 4. Usuario de prueba

```
Correo:     demo@ejemplo.com
Contraseña: Demo1234
```

También puedes crear una cuenta desde la pantalla de registro; se guardará
en la tabla `usuarios` con la contraseña encriptada mediante `password_hash()`.

## 5. Estructura de la tabla `usuarios`

| Campo        | Tipo           | Descripción                          |
|--------------|----------------|--------------------------------------|
| `id`         | INT UNSIGNED   | Identificador autoincremental        |
| `usuario`    | VARCHAR(50)    | Nombre de usuario                    |
| `email`      | VARCHAR(120)   | Correo único                         |
| `telefono`   | VARCHAR(20)    | Teléfono                             |
| `password`   | VARCHAR(255)   | Contraseña encriptada                |
| `created_at` | TIMESTAMP      | Fecha de creación                    |

## 6. Comprobar la conexión

Desde la terminal:

```powershell
& "C:\xampp\php\php.exe" -r "require 'C:/xampp/htdocs/LoginModeloVistaControlador/config/database.php'; var_dump(db()->query('SELECT 1')->fetchColumn());"
```

Debe imprimir:

```text
string(1) "1"
```
