<?php
namespace Infrastructure\Persistence;

use PDO;
use Domain\Entity\User;
use Domain\Contract\UserRepositoryInterface;

final class DatabaseUserRepository implements UserRepositoryInterface
{
    public function __construct(private PDO $db) {}

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare(
            'SELECT id, email, password, is_active FROM users WHERE email = :email'
        );

        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row 
            ? new User((int)$row['id'], 
              $row['email'], 
              $row['password'], 
              (bool)$row['is_active']) 
            : null;
    }
}