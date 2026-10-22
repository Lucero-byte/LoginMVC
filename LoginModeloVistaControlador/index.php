<?php
declare(strict_types=1);

/**
 * Enrutador principal.
 *
 * Rutas disponibles:
 *   index.php                          -> login
 *   index.php?controller=login         -> login
 *   index.php?controller=registro      -> registro
 *   index.php?controller=recuperar     -> recuperar contraseña
 *
 * Los formularios usan además action=guardar / action=enviar.
 */

date_default_timezone_set('America/Lima');

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

$controller = strtolower(trim((string) ($_GET['controller'] ?? 'login')));
$action     = trim((string) ($_GET['action'] ?? 'index'));

$routes = [
    'login' => [
        'file'    => __DIR__ . '/app/Controllers/loginController.php',
        'class'   => 'loginController',
        'actions' => ['index', 'autenticar', 'salir'],
    ],
    'inicio' => [
        'file'    => __DIR__ . '/app/Controllers/inicioController.php',
        'class'   => 'inicioController',
        'actions' => ['index'],
    ],
    'registro' => [
        'file'    => __DIR__ . '/app/Controllers/registroController.php',
        'class'   => 'registroController',
        'actions' => ['index', 'guardar'],
    ],
    'recuperar' => [
        'file'    => __DIR__ . '/app/Controllers/recuperarController.php',
        'class'   => 'recuperarController',
        'actions' => ['index', 'enviar'],
    ],
];

if (!isset($routes[$controller]) || !in_array($action, $routes[$controller]['actions'], true)) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página no encontrada</title>
        <style>
            body {
                margin: 0;
                min-height: 100vh;
                display: grid;
                place-items: center;
                font-family: "Segoe UI", system-ui, sans-serif;
                color: #1f2937;
                background: #eef1f8;
            }
            .caja {
                padding: 36px;
                text-align: center;
                background: #ffffff;
                border-radius: 16px;
                box-shadow: 0 20px 45px -22px rgba(30, 41, 59, .35);
            }
            h1 { margin: 0 0 10px; font-size: 1.5rem; }
            p { margin: 0 0 20px; color: #64748b; }
            a { color: #4f46e5; font-weight: 600; text-decoration: none; }
            a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <section class="caja">
            <h1>Página no encontrada</h1>
            <p>La ruta solicitada no existe.</p>
            <a href="index.php">Volver al inicio de sesión</a>
        </section>
    </body>
    </html>
    <?php
    exit;
}

require_once $routes[$controller]['file'];

$class     = $routes[$controller]['class'];
$instancia = new $class();
$instancia->{$action}();
