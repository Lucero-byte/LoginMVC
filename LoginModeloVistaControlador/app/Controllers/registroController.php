<?php
declare(strict_types=1);

require_once __DIR__ . '/../Models/registroModel.php';

/**
 * Controlador del registro de usuarios.
 */
class registroController
{
    public function index(): void
    {
        if (!empty($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=inicio');
            exit;
        }

        $datos        = [];
        $errores      = [];
        $mensajeExito = '';

        require __DIR__ . '/../Views/registro.php';
    }

    public function guardar(): void
    {
        if (!empty($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=inicio');
            exit;
        }

        $datos = [
            'usuario'  => trim((string) ($_POST['usuario'] ?? '')),
            'telefono' => trim((string) ($_POST['telefono'] ?? '')),
            'email'    => strtolower(trim((string) ($_POST['email'] ?? ''))),
        ];

        $password  = (string) ($_POST['password'] ?? '');
        $confirmar = (string) ($_POST['confirmar_password'] ?? '');

        $errores      = [];
        $mensajeExito = '';

        $largoUsuario = mb_strlen($datos['usuario'], 'UTF-8');

        if ($largoUsuario < 3 || $largoUsuario > 50) {
            $errores[] = 'El nombre de usuario debe tener entre 3 y 50 caracteres.';
        }

        $telefonoDigitos = preg_replace('/\D/', '', $datos['telefono']) ?? '';

        if (
            !preg_match('/^[0-9+()\-\s]{7,20}$/', $datos['telefono']) ||
            strlen($telefonoDigitos) < 7
        ) {
            $errores[] = 'Ingresa un número de teléfono válido de 7 a 20 dígitos.';
        }

        if (
            $datos['email'] === '' ||
            strlen($datos['email']) > 120 ||
            !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)
        ) {
            $errores[] = 'Ingresa un correo electrónico válido.';
        }

        if (strlen($password) < 8) {
            $errores[] = 'La contraseña debe tener al menos 8 caracteres.';
        } elseif ($password !== $confirmar) {
            $errores[] = 'Las contraseñas no coinciden.';
        }

        if (empty($errores)) {
            try {
                $modelo = new registroModel();

                if ($modelo->emailExiste($datos['email'])) {
                    $errores[] = 'Ya existe una cuenta con ese correo electrónico.';
                } else {
                    $modelo->crear(
                        $datos,
                        password_hash($password, PASSWORD_DEFAULT)
                    );

                    $_SESSION['login_exito'] = 'Tu cuenta fue creada correctamente. Ya puedes iniciar sesión.';

                    header('Location: index.php?controller=login');
                    exit;
                }
            } catch (PDOException $e) {
                // 23000 = restricción de duplicado en MySQL/MariaDB.
                if ($e->getCode() === '23000') {
                    $errores[] = 'Ya existe una cuenta con ese correo electrónico.';
                } else {
                    $errores[] = 'No se pudo crear la cuenta. Inténtalo más tarde.';
                }
            }
        }

        require __DIR__ . '/../Views/registro.php';
    }
}
