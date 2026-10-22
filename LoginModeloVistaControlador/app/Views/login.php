<?php
/**
 * Vista de inicio de sesión (front-end).
 * Los enlaces a registro.php y recuperar.php corresponden a las partes
 * que desarrollan los demás integrantes del equipo.
 */

$docRoot    = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '');
$viewDir    = str_replace('\\', '/', __DIR__);
$projectDir = dirname($viewDir, 2);

$basePath = ($docRoot !== '' && str_starts_with($viewDir, $docRoot))
    ? str_replace($docRoot, '', $projectDir)
    : '../..';

$assetsUrl = rtrim($basePath, '/') . '/assets';
$viewsUrl  = rtrim($basePath, '/') . '/app/Views';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicio de sesión del sistema">
    <meta name="theme-color" content="#4f46e5">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="<?= htmlspecialchars($assetsUrl, ENT_QUOTES, 'UTF-8') ?>/css/login.css">
</head>
<body>
    <main class="login-shell">

        <section class="form-panel">
            <div class="form-card">

                <header class="form-header">
                    <p class="form-eyebrow">Iniciar sesión</p>
                    <h2>Accede a tu cuenta</h2>
                    <p class="form-subtitle">Usa el correo y la contraseña con los que te registraste.</p>
                </header>

                <div class="form-alert" id="formAlert" role="alert" hidden>
                    <svg class="form-alert__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M12 8v4"></path>
                        <path d="M12 16h.01"></path>
                    </svg>
                    <span id="formAlertText"></span>
                </div>

                <!-- data-demo="true" simula el envío mientras no exista backend.
                     Cuando conecten la base de datos, quiten ese atributo. -->
                <form id="loginForm" action="" method="post" novalidate data-demo="true">

                    <div class="field">
                        <label for="correo">Correo electrónico</label>
                        <div class="field-control">
                            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                <path d="M3 7l9 6 9-6"></path>
                            </svg>
                            <input
                                type="email"
                                id="correo"
                                name="correo"
                                placeholder="tucorreo@ejemplo.com"
                                autocomplete="email"
                                inputmode="email"
                                required
                                aria-describedby="correoError"
                            >
                        </div>
                        <p class="field-error" id="correoError" aria-live="polite"></p>
                    </div>

                    <div class="field">
                        <label for="clave">Contraseña</label>
                        <div class="field-control">
                            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="4" y="10" width="16" height="11" rx="2"></rect>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"></path>
                            </svg>
                            <input
                                type="password"
                                id="clave"
                                name="clave"
                                placeholder="Tu contraseña"
                                autocomplete="current-password"
                                required
                                aria-describedby="claveError"
                            >
                            <button type="button" class="password-toggle" id="togglePassword" aria-label="Mostrar contraseña" aria-pressed="false">
                                <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg class="eye-off-icon is-hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M17.9 17.9A10.6 10.6 0 0 1 12 19c-6.5 0-10-7-10-7a18.8 18.8 0 0 1 4.1-5.1"></path>
                                    <path d="M9.9 5.2A10.6 10.6 0 0 1 12 5c6.5 0 10 7 10 7a18.9 18.9 0 0 1-2.3 3.3"></path>
                                    <path d="M14.1 14.1a3 3 0 0 1-4.2-4.2"></path>
                                    <path d="M3 3l18 18"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="field-error" id="claveError" aria-live="polite"></p>
                    </div>

                    <div class="form-row">
                        <label class="checkbox">
                            <input type="checkbox" name="recordar" id="recordar" value="1">
                            <span class="checkbox__box">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                            </span>
                            <span class="checkbox__label">Recordarme</span>
                        </label>

                        <a class="link-muted" href="<?= htmlspecialchars($viewsUrl, ENT_QUOTES, 'UTF-8') ?>/recuperar.php">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <span class="btn-submit__text">Ingresar</span>
                        <span class="btn-submit__spinner" aria-hidden="true"></span>
                    </button>
                </form>

                <p class="form-register">
                    ¿Aún no tienes cuenta?
                    <a href="<?= htmlspecialchars($viewsUrl, ENT_QUOTES, 'UTF-8') ?>/registro.php">Crear una cuenta</a>
                </p>

                <p class="form-legal">Al continuar aceptas las políticas de uso del sistema.</p>
            </div>
        </section>
    </main>

    <script src="<?= htmlspecialchars($assetsUrl, ENT_QUOTES, 'UTF-8') ?>/js/login.js"></script>
</body>
</html>
