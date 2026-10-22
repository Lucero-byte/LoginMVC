<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

/**
 * Acceso a los datos de usuarios.
 */
class loginModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = db();
    }

    /**
     * Busca un usuario por su correo electrónico.
     */
    public function buscarPorEmail(string $email): ?array
    {
        $sql = 'SELECT id, usuario, email, password
                FROM usuarios
                WHERE email = :email
                LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }
}
