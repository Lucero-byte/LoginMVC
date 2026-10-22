<?php
declare(strict_types=1);

require_once __DIR__ . '/../Models/loginModel.php';

/**
 * Controlador del inicio de sesión.
 */
class loginController
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function index(): void
    {
        if (!empty($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=inicio');
            exit;
        }

        $errores      = $_SESSION['login_errores'] ?? [];
        $datos        = ['correo' => $_SESSION['login_correo'] ?? ''];
        $mensajeExito = $_SESSION['login_exito'] ?? '';

        unset(
            $_SESSION['login_errores'],
            $_SESSION['login_correo'],
            $_SESSION['login_exito']
        );

        require __DIR__ . '/../Views/login.php';
    }

    /**
     * Valida las credenciales contra la base de datos y crea la sesión.
     */
    public function autenticar(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            header('Location: index.php?controller=login');
            exit;
        }

        $correo = strtolower(trim((string) ($_POST['correo'] ?? '')));
        $clave  = (string) ($_POST['clave'] ?? '');

        $errores = [];

        if ($correo === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'Ingresa un correo electrónico válido.';
        }

        if ($clave === '') {
            $errores[] = 'Ingresa tu contraseña.';
        }

        if (empty($errores)) {
            try {
                $modelo  = new loginModel();
                $usuario = $modelo->buscarPorEmail($correo);

                if ($usuario !== null && password_verify($clave, $usuario['password'])) {
                    session_regenerate_id(true);

                    $_SESSION['usuario_id'] = (int) $usuario['id'];
                    $_SESSION['usuario']    = $usuario['usuario'];
                    $_SESSION['email']      = $usuario['email'];

                    header('Location: index.php?controller=inicio');
                    exit;
                }

                $errores[] = 'Correo o contraseña incorrectos.';
            } catch (PDOException $e) {
                $errores[] = 'No se pudo conectar con la base de datos. Inténtalo más tarde.';
            }
        }

        $_SESSION['login_errores'] = $errores;
        $_SESSION['login_correo']  = $correo;

        header('Location: index.php?controller=login');
        exit;
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function salir(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: index.php?controller=login');
        exit;
    }
}
