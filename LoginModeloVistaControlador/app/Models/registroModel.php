<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

/**
 * Acceso a los datos del registro de usuarios.
 */
class registroModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = db();
    }

    /**
     * Comprueba si un correo ya está registrado.
     */
    public function emailExiste(string $email): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1 FROM usuarios WHERE email = :email LIMIT 1'
        );

        $stmt->execute(['email' => $email]);

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Guarda un usuario nuevo. La contraseña ya debe venir hasheada.
     */
    public function crear(array $datos, string $passwordHash): bool
    {
        $sql = 'INSERT INTO usuarios (usuario, email, telefono, password)
                VALUES (:usuario, :email, :telefono, :password)';

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'usuario'  => $datos['usuario'],
            'email'    => $datos['email'],
            'telefono' => $datos['telefono'],
            'password' => $passwordHash,
        ]);
    }
}
