<?php
declare(strict_types=1);

/**
 * Calcula las URL base del proyecto para que las vistas funcionen
 * tanto si se abren directamente como si se cargan desde index.php.
 */

$docRoot   = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '');
$viewsDir  = str_replace('\\', '/', realpath(__DIR__ . '/..') ?: dirname(__DIR__));
$projectDir = dirname($viewsDir, 2);

$basePath = ($docRoot !== '' && str_starts_with($viewsDir, $docRoot))
    ? str_replace($docRoot, '', $projectDir)
    : '../..';

$basePath = rtrim($basePath, '/');

$routerUrl = $basePath . '/index.php';
$assetsUrl = $basePath . '/assets';

/** URL de una ruta del enrutador, ya escapada para HTML. */
$url = static fn(string $query = ''): string => htmlspecialchars(
    $routerUrl . $query,
    ENT_QUOTES,
    'UTF-8'
);

/** URL de un archivo dentro de assets/, ya escapada para HTML. */
$assetUrl = static fn(string $path): string => htmlspecialchars(
    $assetsUrl . '/' . ltrim($path, '/'),
    ENT_QUOTES,
    'UTF-8'
);
