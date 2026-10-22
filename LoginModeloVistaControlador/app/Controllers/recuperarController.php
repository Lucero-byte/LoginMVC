<?php
declare(strict_types=1);

/**
 * Controlador de la recuperación de contraseña.
 *
 * Etapa actual: solo front-end. La solicitud se valida, pero todavía
 * no se consulta la base de datos ni se envía ningún correo.
 */
class recuperarController
{
    public function index(): void
    {
        $datos        = [];
        $errores      = [];
        $mensajeExito = '';

        require __DIR__ . '/../Views/recuperar.php';
    }

    public function enviar(): void
    {
        $datos = [
            'correo' => trim((string) ($_POST['correo'] ?? '')),
        ];

        $errores      = [];
        $mensajeExito = '';

        if ($datos['correo'] === '') {
            $errores[] = 'Ingresa tu correo electrónico.';
        } elseif (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'Escribe un correo electrónico válido.';
        }

        if (empty($errores)) {
            // TODO (backend): buscar el correo y enviar el enlace de recuperación.
            // Se usa un mensaje genérico para no revelar si el correo existe.
            $mensajeExito = 'Si el correo está registrado, recibirás un enlace para restablecer tu contraseña. Revisa también tu carpeta de spam.';
            $datos = [];
        }

        require __DIR__ . '/../Views/recuperar.php';
    }
}
