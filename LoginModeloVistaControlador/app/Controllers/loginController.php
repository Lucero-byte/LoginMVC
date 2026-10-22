<?php
declare(strict_types=1);

/**
 * Controlador del inicio de sesión.
 *
 * Etapa actual: solo front-end.
 * Aquí se validarán las credenciales usando loginModel 
 */
class loginController
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function index(): void
    {
        require_once __DIR__ . '/../Views/login.php';
    }

    /**
     * TODO (backend): recibir el POST del formulario, validar los datos
     * y autenticar al usuario contra la base de datos.
     *
     * public function autenticar(): void
     * {
     *     $correo = trim($_POST['correo'] ?? '');
     *     $clave  = $_POST['clave'] ?? '';
     *
     *     // Validar, consultar loginModel y crear la sesión.
     * }
     */
}
