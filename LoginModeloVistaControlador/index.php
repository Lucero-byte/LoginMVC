<?php
declare(strict_types=1);

/**
 * Punto de entrada del proyecto.
 * Por ahora solo carga la vista de inicio de sesión (etapa front-end).
 */

require_once __DIR__ . '/app/Controllers/loginController.php';

$controlador = new loginController();
$controlador->index();
