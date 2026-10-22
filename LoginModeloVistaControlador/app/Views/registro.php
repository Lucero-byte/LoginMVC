<?php
require_once __DIR__ . '/partials/urls.php';

$datos   = $datos ?? [];
$errores = $errores ?? [];
$valor   = static fn(string $campo): string => htmlspecialchars($datos[$campo] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            font-family: "Segoe UI", system-ui, -apple-system, Roboto, Arial, sans-serif;
            color: #1f2937;
            background: #f2f4f8;
        }

        .tarjeta {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 32px 28px 26px;
            box-shadow: 0 10px 25px -12px rgba(30, 41, 59, .25);
        }

        h1 {
            font-size: 1.35rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 4px;
        }

        .subtitulo {
            margin-bottom: 24px;
            font-size: .875rem;
            color: #6b7280;
            text-align: center;
        }

        .alerta {
            padding: 11px 13px;
            margin-bottom: 18px;
            border-radius: 8px;
            font-size: .85rem;
            line-height: 1.45;
        }

        .alerta-error {
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .alerta-exito {
            color: #065f46;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
        }

        .alerta ul {
            margin-left: 16px;
        }

        .campo {
            margin-bottom: 15px;
        }

        .campo label {
            display: block;
            margin-bottom: 6px;
            font-size: .85rem;
            font-weight: 600;
            color: #374151;
        }

        .control {
            position: relative;
        }

        .control input {
            width: 100%;
            padding: 10px 12px;
            font-size: .95rem;
            font-family: inherit;
            color: #1f2937;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .control input::placeholder {
            color: #9ca3af;
        }

        .control input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, .15);
        }

        .control input[type="password"] {
            padding-right: 40px;
        }

        .ver-clave {
            position: absolute;
            top: 50%;
            right: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            padding: 0;
            color: #9ca3af;
            background: transparent;
            border: 0;
            border-radius: 6px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .ver-clave:hover {
            color: #4f46e5;
        }

        .ver-clave svg {
            width: 18px;
            height: 18px;
        }

        .oculto {
            display: none !important;
        }

        .error-campo {
            display: none;
            margin-top: 5px;
            font-size: .78rem;
            color: #dc2626;
        }

        .campo.invalido .error-campo {
            display: block;
        }

        .campo.invalido input {
            border-color: #dc2626;
        }

        .campo.invalido input:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, .13);
        }

        .acciones {
            display: flex;
            gap: 10px;
            margin-top: 22px;
        }

        .btn {
            flex: 1;
            padding: 10px 16px;
            font-size: .95rem;
            font-weight: 600;
            font-family: inherit;
            border-radius: 8px;
            border: 1px solid transparent;
            cursor: pointer;
            transition: background .15s, border-color .15s, color .15s;
        }

        a.btn {
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.2;
            text-decoration: none;
        }

        .btn:focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, .25);
        }

        .btn-ok {
            color: #ffffff;
            background: #4f46e5;
        }

        .btn-ok:hover {
            background: #4338ca;
        }

        .btn-cancelar {
            color: #374151;
            background: #ffffff;
            border-color: #d1d5db;
        }

        .btn-cancelar:hover {
            background: #f3f4f6;
        }

        .pie {
            margin-top: 18px;
            font-size: .85rem;
            color: #6b7280;
            text-align: center;
        }

        .pie a {
            color: #4f46e5;
            font-weight: 600;
            text-decoration: none;
        }

        .pie a:hover {
            text-decoration: underline;
        }

        @media (max-width: 420px) {
            .tarjeta {
                padding: 24px 18px 20px;
            }

            .acciones {
                flex-direction: column-reverse;
            }
        }
    </style>
</head>
<body>
    <main class="tarjeta">
        <h1>Registro de usuario</h1>
        <p class="subtitulo">Completa tus datos para crear la cuenta</p>

        <?php if (!empty($errores)): ?>
            <div class="alerta alerta-error" role="alert">
                <strong>Revisa lo siguiente:</strong>
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensajeExito)): ?>
            <div class="alerta alerta-exito" role="status">
                <?= htmlspecialchars($mensajeExito, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form id="formRegistro" method="post" action="<?= $url('?controller=registro&action=guardar') ?>" novalidate>
            <div class="campo" data-campo="usuario">
                <label for="usuario">Nombre de usuario</label>
                <div class="control">
                    <input
                        type="text"
                        id="usuario"
                        name="usuario"
                        value="<?= $valor('usuario') ?>"
                        placeholder="Ej: maria_lopez"
                        autocomplete="username"
                        minlength="3"
                        maxlength="30"
                        required
                        autofocus
                        aria-describedby="error-usuario"
                    >
                </div>
                <p class="error-campo" id="error-usuario" data-error-for="usuario">Ingresa un nombre de usuario de al menos 3 caracteres.</p>
            </div>

            <div class="campo" data-campo="telefono">
                <label for="telefono">Número de teléfono</label>
                <div class="control">
                    <input
                        type="tel"
                        id="telefono"
                        name="telefono"
                        value="<?= $valor('telefono') ?>"
                        placeholder="Ej: +51 999 123 456"
                        autocomplete="tel"
                        inputmode="tel"
                        pattern="[0-9+()\-\s]{7,20}"
                        maxlength="20"
                        required
                        aria-describedby="error-telefono"
                    >
                </div>
                <p class="error-campo" id="error-telefono" data-error-for="telefono">Ingresa un teléfono válido de 7 a 20 dígitos.</p>
            </div>

            <div class="campo" data-campo="email">
                <label for="email">Correo electrónico</label>
                <div class="control">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= $valor('email') ?>"
                        placeholder="tucorreo@ejemplo.com"
                        autocomplete="email"
                        maxlength="120"
                        required
                        aria-describedby="error-email"
                    >
                </div>
                <p class="error-campo" id="error-email" data-error-for="email">Ingresa un correo electrónico válido.</p>
            </div>

            <div class="campo" data-campo="password">
                <label for="password">Contraseña</label>
                <div class="control">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Mínimo 8 caracteres"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        aria-describedby="error-password"
                    >
                    <button type="button" class="ver-clave" data-objetivo="password" aria-label="Mostrar contraseña" title="Mostrar contraseña" aria-pressed="false">
                        <svg class="ojo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg class="ojo-tachado oculto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17.9 17.9A10.6 10.6 0 0 1 12 19c-6.5 0-10-7-10-7a18.8 18.8 0 0 1 4.1-5.1"/>
                            <path d="M9.9 5.2A10.6 10.6 0 0 1 12 5c6.5 0 10 7 10 7a18.9 18.9 0 0 1-2.3 3.3"/>
                            <path d="M14.1 14.1a3 3 0 0 1-4.2-4.2"/>
                            <path d="M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
                <p class="error-campo" id="error-password" data-error-for="password">La contraseña debe tener al menos 8 caracteres.</p>
            </div>

            <div class="campo" data-campo="confirmar_password">
                <label for="confirmar_password">Confirmar contraseña</label>
                <div class="control">
                    <input
                        type="password"
                        id="confirmar_password"
                        name="confirmar_password"
                        placeholder="Repite tu contraseña"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        aria-describedby="error-confirmar_password"
                    >
                    <button type="button" class="ver-clave" data-objetivo="confirmar_password" aria-label="Mostrar contraseña" title="Mostrar contraseña" aria-pressed="false">
                        <svg class="ojo" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg class="ojo-tachado oculto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17.9 17.9A10.6 10.6 0 0 1 12 19c-6.5 0-10-7-10-7a18.8 18.8 0 0 1 4.1-5.1"/>
                            <path d="M9.9 5.2A10.6 10.6 0 0 1 12 5c6.5 0 10 7 10 7a18.9 18.9 0 0 1-2.3 3.3"/>
                            <path d="M14.1 14.1a3 3 0 0 1-4.2-4.2"/>
                            <path d="M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
                <p class="error-campo" id="error-confirmar_password" data-error-for="confirmar_password">Las contraseñas no coinciden.</p>
            </div>

            <div class="acciones">
                <button type="submit" class="btn btn-ok">Crear cuenta</button>
                <a class="btn btn-cancelar" href="<?= $url('?controller=login') ?>">Cancelar</a>
            </div>
        </form>

        <p class="pie">
            ¿Ya tienes cuenta? <a href="<?= $url('?controller=login') ?>">Inicia sesión</a>
        </p>
    </main>

    <script>
        (function () {
            const formulario = document.getElementById('formRegistro');
            const campos = {
                usuario: document.getElementById('usuario'),
                telefono: document.getElementById('telefono'),
                email: document.getElementById('email'),
                password: document.getElementById('password'),
                confirmar_password: document.getElementById('confirmar_password')
            };

            function contenedor(campo) {
                return campo.closest('.campo');
            }

            function marcar(campo, invalido) {
                const caja = contenedor(campo);
                if (caja) caja.classList.toggle('invalido', invalido);

                if (invalido) {
                    campo.setAttribute('aria-invalid', 'true');
                } else {
                    campo.removeAttribute('aria-invalid');
                }
            }

            function validarUsuario() {
                const valido = campos.usuario.value.trim().length >= 3;
                marcar(campos.usuario, !valido);
                return valido;
            }

            function validarTelefono() {
                const valor = campos.telefono.value.trim();
                const valido = /^[0-9+()\-\s]{7,20}$/.test(valor) && valor.replace(/\D/g, '').length >= 7;
                marcar(campos.telefono, !valido);
                return valido;
            }

            function validarEmail() {
                const valor = campos.email.value.trim();
                const valido = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(valor);
                marcar(campos.email, !valido);
                return valido;
            }

            function validarPassword() {
                const valido = campos.password.value.length >= 8;
                marcar(campos.password, !valido);
                return valido;
            }

            function validarConfirmacion() {
                const caja = contenedor(campos.confirmar_password);
                const error = caja.querySelector('.error-campo');
                const valor = campos.confirmar_password.value;

                let valido = true;
                let mensaje = '';

                if (valor.length < 8) {
                    valido = false;
                    mensaje = 'La contraseña debe tener al menos 8 caracteres.';
                } else if (valor !== campos.password.value) {
                    valido = false;
                    mensaje = 'Las contraseñas no coinciden.';
                }

                error.textContent = mensaje || 'Las contraseñas no coinciden.';
                marcar(campos.confirmar_password, !valido);
                return valido;
            }

            // Validar al salir del campo y revalidar mientras se escribe
            const validadores = {
                usuario: validarUsuario,
                telefono: validarTelefono,
                email: validarEmail,
                password: validarPassword,
                confirmar_password: validarConfirmacion
            };

            Object.keys(validadores).forEach(function (nombre) {
                const campo = campos[nombre];
                // No marcar como inválido al salir de un campo vacío:
                // evita advertencias al pulsar "Cancelar" o "Inicia sesión".
                campo.addEventListener('blur', function () {
                    if (campo.value.trim() !== '' || contenedor(campo).classList.contains('invalido')) {
                        validadores[nombre]();
                    }
                });
                campo.addEventListener('input', function () {
                    const caja = contenedor(campo);
                    if (caja && caja.classList.contains('invalido')) {
                        validadores[nombre]();
                    }
                });
            });

            // Al cambiar la contraseña, revisar también la confirmación si ya tenía contenido
            campos.password.addEventListener('input', function () {
                if (campos.confirmar_password.value !== '' &&
                    contenedor(campos.confirmar_password).classList.contains('invalido')) {
                    validarConfirmacion();
                }
            });

            // Mostrar / ocultar contraseña
            document.querySelectorAll('.ver-clave').forEach(function (boton) {
                boton.addEventListener('click', function () {
                    const input = document.getElementById(boton.dataset.objetivo);
                    const mostrar = input.type === 'password';

                    input.type = mostrar ? 'text' : 'password';
                    boton.setAttribute('aria-pressed', String(mostrar));
                    boton.setAttribute('aria-label', mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña');
                    boton.setAttribute('title', mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña');
                    boton.querySelector('.ojo').classList.toggle('oculto', mostrar);
                    boton.querySelector('.ojo-tachado').classList.toggle('oculto', !mostrar);
                    input.focus();
                });
            });

            formulario.addEventListener('submit', function (evento) {
                const resultados = [
                    validarUsuario(),
                    validarTelefono(),
                    validarEmail(),
                    validarPassword(),
                    validarConfirmacion()
                ];

                if (resultados.includes(false)) {
                    evento.preventDefault();
                    const primerError = formulario.querySelector('.campo.invalido input');
                    if (primerError) primerError.focus();
                }
            });
        })();
    </script>
</body>
</html>
