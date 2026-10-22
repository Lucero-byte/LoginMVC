<?php
declare(strict_types=1);

/**
 * Vista de bienvenida después de iniciar sesión.
 */
class inicioController
{
    public function index(): void
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=login');
            exit;
        }

        $nombre = (string) ($_SESSION['usuario'] ?? 'Usuario');
        $email  = (string) ($_SESSION['email'] ?? '');

        $hora = (int) date('G');

        if ($hora < 12) {
            $saludo = 'Buenos días';
        } elseif ($hora < 19) {
            $saludo = 'Buenas tardes';
        } else {
            $saludo = 'Buenas noches';
        }

        $fecha      = date('d/m/Y');
        $horaActual = date('H:i');

        require __DIR__ . '/../Views/inicio.php';
    }
}
