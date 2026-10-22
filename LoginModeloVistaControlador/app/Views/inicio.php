<?php
require_once __DIR__ . '/partials/urls.php';

$nombre     = $nombre ?? 'Usuario';
$email      = $email ?? '';
$saludo     = $saludo ?? 'Bienvenido';
$fecha      = $fecha ?? date('d/m/Y');
$horaActual = $horaActual ?? date('H:i');
$inicial    = mb_strtoupper(mb_substr($nombre, 0, 1), 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bienvenida al sistema">
    <meta name="theme-color" content="#4f46e5">
    <title>Bienvenido | Portal de acceso</title>
    <link rel="stylesheet" href="<?= $assetUrl('css/inicio.css') ?>">
</head>
<body>
    <main class="welcome-card">
        <header class="welcome-header">
            <span class="brand">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3l7 3v5c0 4.5-3 7.9-7 9-4-1.1-7-4.5-7-9V6l7-3z"></path>
                        <path d="M9.5 12l1.8 1.8 3.4-3.6"></path>
                    </svg>
                </span>
                <span class="brand-name">Portal de acceso</span>
            </span>

            <a class="logout-link" href="<?= $url('?controller=login&action=salir') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <path d="M16 17l5-5-5-5"></path>
                    <path d="M21 12H9"></path>
                </svg>
                Cerrar sesión
            </a>
        </header>

        <section class="welcome-content">
            <div class="avatar" aria-hidden="true"><?= htmlspecialchars($inicial, ENT_QUOTES, 'UTF-8') ?></div>

            <p class="eyebrow">Sesión iniciada</p>
            <h1><?= htmlspecialchars($saludo, ENT_QUOTES, 'UTF-8') ?>, <span><?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></span></h1>
            <p class="subtitle">Bienvenido al sistema. Nos alegra tenerte de vuelta.</p>

            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Usuario</span>
                    <strong class="info-value"><?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></strong>
                </div>

                <div class="info-item">
                    <span class="info-label">Correo</span>
                    <strong class="info-value"><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></strong>
                </div>

                <div class="info-item">
                    <span class="info-label">Fecha</span>
                    <strong class="info-value"><?= htmlspecialchars($fecha, ENT_QUOTES, 'UTF-8') ?></strong>
                </div>

                <div class="info-item">
                    <span class="info-label">Hora</span>
                    <strong class="info-value"><?= htmlspecialchars($horaActual, ENT_QUOTES, 'UTF-8') ?></strong>
                </div>
            </div>
        </section>

        <footer class="welcome-footer">
            <span class="status-dot" aria-hidden="true"></span>
            Has iniciado sesión correctamente.
        </footer>
    </main>
</body>
</html>
