<?php
require_once __DIR__ . '/partials/urls.php';

$datos        = $datos ?? [];
$errores      = $errores ?? [];
$mensajeExito = $mensajeExito ?? '';
$correo       = htmlspecialchars($datos['correo'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Recuperación de contraseña">
    <meta name="theme-color" content="#4f46e5">
    <title>Recuperar contraseña</title>
    <style>
        :root {
            --accent: #6366f1;
            --accent-strong: #4f46e5;
            --accent-soft: #eef2ff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --surface: #ffffff;
            --field: #f8fafc;
            --danger: #dc2626;
            --success: #047857;
            --font: "Segoe UI", system-ui, -apple-system, "Helvetica Neue", Arial, sans-serif;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            min-height: 100dvh;
            display: grid;
            place-items: center;
            padding: 32px 20px;
            font-family: var(--font);
            color: var(--text);
            background:
                radial-gradient(circle at 12% 18%, rgba(99, 102, 241, .16), transparent 42%),
                radial-gradient(circle at 88% 82%, rgba(14, 165, 233, .14), transparent 44%),
                #eef1f8;
        }

        svg {
            display: block;
        }

        .card {
            width: min(440px, 100%);
            padding: 40px 36px 32px;
            background: var(--surface);
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 28px;
            box-shadow: 0 32px 80px -32px rgba(23, 18, 57, .45);
        }

        .icon-badge {
            width: 56px;
            height: 56px;
            display: grid;
            place-items: center;
            margin-bottom: 22px;
            color: #ffffff;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            border-radius: 16px;
            box-shadow: 0 12px 24px -12px rgba(79, 70, 229, .7);
        }

        .icon-badge svg {
            width: 26px;
            height: 26px;
        }

        .eyebrow {
            margin: 0 0 8px;
            font-size: .76rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--accent-strong);
        }

        h1 {
            margin: 0 0 12px;
            font-size: 1.75rem;
            line-height: 1.2;
            letter-spacing: -.025em;
        }

        .subtitle {
            margin: 0 0 26px;
            font-size: .94rem;
            line-height: 1.6;
            color: var(--muted);
        }

        /* Alertas */

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
            padding: 12px 14px;
            border: 1px solid transparent;
            border-radius: 12px;
            font-size: .87rem;
            line-height: 1.5;
        }

        .alert svg {
            flex: 0 0 auto;
            width: 18px;
            height: 18px;
            margin-top: 1px;
        }

        .alert-error {
            color: #991b1b;
            background: #fef2f2;
            border-color: #fecaca;
        }

        .alert-success {
            color: var(--success);
            background: #ecfdf5;
            border-color: #a7f3d0;
        }

        .alert ul {
            margin: 0;
            padding-left: 18px;
        }

        /* Campo */

        .field {
            margin-bottom: 22px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: .88rem;
            font-weight: 600;
            color: #334155;
        }

        .control {
            position: relative;
        }

        .control-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            width: 19px;
            height: 19px;
            color: #94a3b8;
            transform: translateY(-50%);
            pointer-events: none;
            transition: color .2s ease;
        }

        .control input {
            width: 100%;
            height: 50px;
            padding: 0 14px 0 46px;
            font-family: inherit;
            font-size: .95rem;
            color: var(--text);
            background: var(--field);
            border: 1px solid var(--border);
            border-radius: 14px;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .control input::placeholder {
            color: #94a3b8;
        }

        .control input:hover {
            border-color: #cbd5e1;
        }

        .control input:focus {
            background: var(--surface);
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .14);
        }

        .control:focus-within .control-icon {
            color: var(--accent-strong);
        }

        .control input[aria-invalid="true"] {
            border-color: #f87171;
            background: #fff5f5;
        }

        .control input[aria-invalid="true"]:focus {
            box-shadow: 0 0 0 4px rgba(248, 113, 113, .16);
        }

        .error {
            display: none;
            margin: 7px 2px 0;
            font-size: .8rem;
            line-height: 1.4;
            color: var(--danger);
        }

        .field.invalido .error {
            display: block;
        }

        /* Botones */

        .btn-primary {
            position: relative;
            width: 100%;
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 20px;
            font-family: inherit;
            font-size: .98rem;
            font-weight: 600;
            color: #ffffff;
            text-decoration: none;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            border: 0;
            border-radius: 14px;
            cursor: pointer;
            box-shadow: 0 14px 28px -14px rgba(79, 70, 229, .7);
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.04);
            box-shadow: 0 18px 32px -14px rgba(79, 70, 229, .8);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:focus-visible {
            outline: 3px solid rgba(99, 102, 241, .35);
            outline-offset: 2px;
        }

        .btn-primary:disabled {
            cursor: wait;
            filter: saturate(.85);
            transform: none;
        }

        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2.2px solid rgba(255, 255, 255, .4);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: girar .7s linear infinite;
        }

        .btn-primary.is-loading .spinner {
            display: block;
        }

        .btn-primary.is-loading .btn-text {
            opacity: .85;
        }

        @keyframes girar {
            to { transform: rotate(360deg); }
        }

        /* Enlaces */

        .back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-top: 20px;
            font-size: .88rem;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            transition: color .18s ease;
        }

        .back-link:hover {
            color: var(--accent-strong);
        }

        .back-link svg {
            width: 16px;
            height: 16px;
        }

        .note {
            margin: 18px 0 0;
            padding-top: 18px;
            font-size: .76rem;
            line-height: 1.55;
            text-align: center;
            color: #94a3b8;
            border-top: 1px solid var(--border);
        }

        .success-actions {
            margin-top: 4px;
        }

        @media (max-width: 480px) {
            body {
                padding: 0;
                background: var(--surface);
            }

            .card {
                width: 100%;
                min-height: 100vh;
                min-height: 100dvh;
                padding: 32px 22px 28px;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }

            h1 {
                font-size: 1.55rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>
<body>
    <main class="card">
        <div class="icon-badge" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="10" width="16" height="11" rx="2"></rect>
                <path d="M8 10V7a4 4 0 0 1 8 0v3"></path>
                <path d="M12 14v3"></path>
            </svg>
        </div>

        <p class="eyebrow">Recuperación de cuenta</p>
        <h1>¿Olvidaste tu contraseña?</h1>
        <p class="subtitle">
            Ingresa el correo con el que te registraste y te enviaremos un enlace para restablecerla.
        </p>

        <?php if ($mensajeExito !== ''): ?>
            <div class="alert alert-success" role="status">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"></circle>
                    <path d="M8.5 12.5l2.3 2.3 4.7-5"></path>
                </svg>
                <span><?= htmlspecialchars($mensajeExito, ENT_QUOTES, 'UTF-8') ?></span>
            </div>

            <div class="success-actions">
                <a class="btn-primary" href="<?= $url('?controller=login') ?>">Volver a iniciar sesión</a>
            </div>

            <p class="note">
                ¿No recibiste el correo? Revisa tu carpeta de spam o vuelve a intentarlo en unos minutos.
            </p>
        <?php else: ?>
            <?php if (!empty($errores)): ?>
                <div class="alert alert-error" role="alert">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M12 8v4"></path>
                        <path d="M12 16h.01"></path>
                    </svg>
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form id="formRecuperar" method="post" action="<?= $url('?controller=recuperar&action=enviar') ?>" novalidate>
                <div class="field" id="campoCorreo">
                    <label for="correo">Correo electrónico</label>
                    <div class="control">
                        <svg class="control-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                            <path d="M3 7l9 6 9-6"></path>
                        </svg>
                        <input
                            type="email"
                            id="correo"
                            name="correo"
                            value="<?= $correo ?>"
                            placeholder="tucorreo@ejemplo.com"
                            autocomplete="email"
                            inputmode="email"
                            maxlength="120"
                            required
                            autofocus
                            aria-describedby="error-correo"
                        >
                    </div>
                    <p class="error" id="error-correo" aria-live="polite">Ingresa un correo electrónico válido.</p>
                </div>

                <button type="submit" class="btn-primary" id="btnEnviar">
                    <span class="btn-text">Enviar enlace</span>
                    <span class="spinner" aria-hidden="true"></span>
                </button>
            </form>

            <a class="back-link" href="<?= $url('?controller=login') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 12H5"></path>
                    <path d="M12 19l-7-7 7-7"></path>
                </svg>
                Volver a iniciar sesión
            </a>

            <p class="note">
                Por seguridad, no confirmamos si un correo está registrado en el sistema.
            </p>
        <?php endif; ?>
    </main>

    <script>
        (function () {
            const formulario = document.getElementById('formRecuperar');

            if (!formulario) {
                return;
            }

            const correo = document.getElementById('correo');
            const campo = document.getElementById('campoCorreo');
            const boton = document.getElementById('btnEnviar');
            const patronCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

            function marcar(invalido) {
                campo.classList.toggle('invalido', invalido);

                if (invalido) {
                    correo.setAttribute('aria-invalid', 'true');
                } else {
                    correo.removeAttribute('aria-invalid');
                }
            }

            function validar() {
                const valido = patronCorreo.test(correo.value.trim());
                marcar(!valido);
                return valido;
            }

            // Solo se valida al enviar (o al corregir un error).
            // Así, pulsar "Volver" con el campo vacío no muestra advertencias.
            correo.addEventListener('input', function () {
                if (campo.classList.contains('invalido')) {
                    validar();
                }
            });

            formulario.addEventListener('submit', function (evento) {
                if (!validar()) {
                    evento.preventDefault();
                    correo.focus();
                    return;
                }

                boton.disabled = true;
                boton.classList.add('is-loading');
            });
        })();
    </script>
</body>
</html>
