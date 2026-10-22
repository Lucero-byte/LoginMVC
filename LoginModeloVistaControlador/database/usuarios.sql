-- ---------------------------------------------------------------
-- Base de datos del sistema de login
-- Importar desde phpMyAdmin o con:
--   mysql -h 127.0.0.1 -P 3307 -u root < database/usuarios.sql
-- ---------------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `login_mvc`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `login_mvc`;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `usuario` VARCHAR(50) NOT NULL,
    `email` VARCHAR(120) NOT NULL,
    `telefono` VARCHAR(20) DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `usuarios_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuario de prueba
-- Correo:    demo@ejemplo.com
-- Contraseña: Demo1234
INSERT INTO `usuarios` (`usuario`, `email`, `telefono`, `password`)
VALUES (
    'demo',
    'demo@ejemplo.com',
    '+51 999 123 456',
    '$2y$10$MRfdyeINkw7foaX.hd3kbuC3bb1CsM1lEnme.KkkZMzBt8Xcs7FbC'
)
ON DUPLICATE KEY UPDATE
    `usuario` = VALUES(`usuario`),
    `telefono` = VALUES(`telefono`),
    `password` = VALUES(`password`);
