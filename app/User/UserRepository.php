<?php
/**
 * User Repository
 * ---------------
 * Handles user persistence.
 */

namespace App\User;

use PDO;

class UserRepository 
{
    public function __construct(private PDO $db){}

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = :email LIMIT 1"
        );

        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new User(
            $row['id'],
            $row['email'],
            $row['password']
        );
    }
}